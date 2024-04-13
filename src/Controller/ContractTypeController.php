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
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/data/contracttype/showAll', name: 'app_data_contracttype_show_all')]
    public function showAllContractTypes(): Response
    {
        $contractTypes = $this->entityManager
            ->getRepository(ContractType::class)
            ->findAll();

        return $this->render('data/contracttype/showAll.html.twig', [
            'contractTypes' => $contractTypes
        ]);
    }

    #[Route('/data/contracttype/add', name: 'app_data_contracttype_add')]
    public function addContractType(Request $request): Response
    {
        $contractType = new ContractType();

        $form = $this->createForm(AddContractTypeType::class, $contractType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contractType);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_data_contracttype_show_all');
        }

        return $this->render('data/contracttype/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/data/contracttype/edit/{contractTypeId}', name: 'app_data_contracttype_edit')]
    public function editContractType(Request $request, int $contractTypeId): Response
    {
        $contractType = $this->entityManager
            ->getRepository(ContractType::class)
            ->findOneById($contractTypeId);

        $form = $this->createForm(EditContractTypeType::class, $contractType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contractType);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_data_contracttype_show_all');
        }

        return $this->render('data/contracttype/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
