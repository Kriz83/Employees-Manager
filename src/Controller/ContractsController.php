<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\Contract\AddContractType;
use App\Form\Contract\EditContractType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Contract\ContractService;
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
    public function addcontract(Request $request, ContractService $contractService, $employeeId)
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
            
            $contractService->addContract($contract, $form, $employeeId);

            $this->addFlash('success', 'New contract was added.');

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

    /**
     * @Route("/contract/edit/{contractId}", name="app_contract_edit")
     */
    public function edit(Request $request, ContractService $contractService, $contractId)
    {

        $repository = $this->em->getRepository(Contract::class);
        $contract = $repository->findOneById($contractId);

        //check if contract exist
        $this->objectExistenceValidator->validate($contract, $contractId);
        
        //get employee data
        $employee = $contract->getEmployee();
        $employeeId = $employee->getId();
        
        $form = $this->createForm(EditContractType::class, $contract);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            //update contract data
            $contractService->editContract($contract, $form, $employeeId);
            
            $this->addFlash('success', 'Contract data was updated.');

            return $this->redirectToRoute('app_show_contracts', array(
                'employeeId' => $employeeId,
            ));
        }

        return $this->render('contract/edit.html.twig', [
            'contract' => $contract,
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contract/details/{contractId}", name="app_contract_details")
     */
    public function details(Request $request, $contractId)
    {

        $repository = $this->em->getRepository(Contract::class);
        $contract = $repository->findOneById($contractId);

        //check if contract exist
        $this->objectExistenceValidator->validate($contract, $contractId);
        
        //get employee data
        $employee = $contract->getEmployee();
        

        return $this->render('contract/details.html.twig', [
            'contract' => $contract,
            'employee' => $employee,
        ]);
    }

}