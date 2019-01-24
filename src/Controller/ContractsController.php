<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\Employee\AddContractType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContractsController extends AbstractController
{

    /**
     * @Route("/contract/add/{employeeId}", name="app_contract_add")
     */
    public function addcontract(Request $request, EntityManagerInterface $em, $employeeId)
    {

        $contract = new Contract();

        $form = $this->createForm(AddContractType::class, $contract);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contract);
            $em->flush();
        }
        
        return $this->render('contract/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showContracts/{employeeId}", name="app_show_contracts")
     */
    public function showContracts(Request $request, $employeeId)
    {
        return $this->render('contract/show.html.twig');
    }

}