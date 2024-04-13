<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ContractType;
use App\Form\ContractType\AddContractTypeType;
use App\Form\ContractType\EditContractTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContractTypeController extends AbstractController
{
    #[Route('/data/contracttype/showAll', name: 'app_data_contracttype_show_all')]
    public function showAllContractTypes(EntityManagerInterface $entityManager): Response
    {
        //get contractTypes array
        $contractTypes = $entityManager
            ->getRepository(ContractType::class)
            ->findAll();

        return $this->render('data/contracttype/showAll.html.twig', [
            'contractTypes' => $contractTypes
        ]);
    }

    #[Route('/data/contracttype/add', name: 'app_data_contracttype_add')]
    public function addContractType(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contractType = new ContractType();

        $form = $this->createForm(AddContractTypeType::class, $contractType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contractType);
            $entityManager->flush();

            return $this->redirectToRoute('app_data_contracttype_show_all');
        }

        return $this->render('data/contracttype/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/data/contracttype/edit/{contractTypeId}', name: 'app_data_contracttype_edit')]
    public function editContractType(Request $request, EntityManagerInterface $entityManager, int $contractTypeId): Response
    {
        //get contractTypes array
        $contractType = $entityManager
            ->getRepository(ContractType::class)
            ->findOneById($contractTypeId);

        $form = $this->createForm(EditContractTypeType::class, $contractType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contractType);
            $entityManager->flush();

            return $this->redirectToRoute('app_data_contracttype_show_all');
        }

        return $this->render('data/contracttype/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
