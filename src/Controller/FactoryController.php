<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Factory;
use App\Form\Factory\AddFactoryType;
use App\Form\Factory\EditFactoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FactoryController extends AbstractController
{
    #[Route('/data/factory/showAll', name: 'app_data_factories_show_all')]
    public function showAllFactories(EntityManagerInterface $entityManager): Response
    {
        //get factories array
        $factories = $entityManager
            ->getRepository(Factory::class)
            ->findAll();

        return $this->render('data/factory/showAll.html.twig', [
            'factories' => $factories
        ]);
    }

    #[Route('/data/factory/add', name: 'app_data_factories_add')]
    public function addFactory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $factory = new Factory();

        $form = $this->createForm(AddFactoryType::class, $factory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($factory);
            $entityManager->flush();

            return $this->redirectToRoute('app_data_factories_show_all');
        }

        return $this->render('data/factory/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/data/factory/edit/{factoryId}', name: 'app_data_factories_edit')]
    public function editFactory(Request $request, EntityManagerInterface $entityManager, int $factoryId): Response
    {
        //get factories array
        $factory = $entityManager
            ->getRepository(Factory::class)
            ->findOneById($factoryId);

        $form = $this->createForm(EditFactoryType::class, $factory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($factory);
            $entityManager->flush();

            return $this->redirectToRoute('app_data_factories_show_all');
        }

        return $this->render('data/factory/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
