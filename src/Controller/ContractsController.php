<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\Contract\AddContractType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Contract\AddContractService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Validate\ValidateObjectExistenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContractsController extends AbstractController
{
    public function __construct(
        ValidateObjectExistenceService $objectExistenceValidator,
        EntityManagerInterface $em
    ) {
        $this->objectExistenceValidator = $objectExistenceValidator;
        $this->em = $em;
    }

    /**
     * @Route("/contract/add/{employeeId}", name="app_contract_add")
     */
    public function addcontract(Request $request, AddContractService $addContractService, $employeeId)
    {
        $employee = $this->em
            ->getRepository('App:Employee')
            ->findOneById($employeeId);
        
        //check if employee exist
        $this->objectExistenceValidator->validate($employee, $employeeId);

        $contract = new Contract();

        $form = $this->createForm(AddContractType::class, $contract);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
           $addContractService->addContract($form, $employeeId);

            return $this->redirectToRoute('app_show_contracts', array(
                'employeeId' => $employeeId                
            ));
        }
        
        return $this->render('contract/add.html.twig', [
            'form' => $form->createView(),
            'employee' => $employee
        ]);
    }

    /**
     * @Route("/showContracts/{employeeId}", name="app_show_contracts")
     */
    public function showContracts(Request $request, $employeeId)
    {
        $employee = $this->em
            ->getRepository('App:Employee')
            ->findOneById($employeeId);

        //check if employee exist
        $this->objectExistenceValidator->validate($employee, $employeeId);

        $contracts = $this->em
            ->getRepository('App:Contract')
            ->findByEmployee($employee);

        return $this->render('contract/show.html.twig', [
            'employee' => $employee,
            'contracts' => $contracts,
        ]);
    }

}