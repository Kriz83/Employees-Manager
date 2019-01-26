<?php

namespace App\Controller;

use App\Entity\ContractType;
use App\Form\ContractType\AddContractTypeType;
use App\Form\ContractType\EditContractTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContractTypeController extends AbstractController
{

    /**
     * @Route("/data/contracttype/showAll", name="app_data_contracttype_show_all")
     */
    public function showAllContractTypes(EntityManagerInterface $em)
    {
        //get contractTypes array
        $contractTypes = $em
            ->getRepository('App:ContractType')
            ->findAll();
       
        return $this->render('data/contracttype/showAll.html.twig', array(
            'contractTypes' => $contractTypes
        ));
    }

    /**
     * @Route("/data/contracttype/add", name="app_data_contracttype_add")
     */
    public function addContractType(Request $request, EntityManagerInterface $em)
    {       
        $contractType = new ContractType();

        $form = $this->createForm(AddContractTypeType::class, $contractType);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contractType);
            $em->flush();

            return $this->redirectToRoute('app_data_contracttype_show_all', array(
            ));
        }

        return $this->render('data/contracttype/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/data/contracttype/edit/{contractTypeId}", name="app_data_contracttype_edit")
     */
    public function editContractType(Request $request, EntityManagerInterface $em, $contractTypeId)
    {       
        //get contractTypes array
        $contractType = $em
            ->getRepository('App:ContractType')
            ->findOneById($contractTypeId);

        $form = $this->createForm(EditContractTypeType::class, $contractType);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contractType);
            $em->flush();

            return $this->redirectToRoute('app_data_contracttype_show_all', array(
            ));
        }

        return $this->render('data/contracttype/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
