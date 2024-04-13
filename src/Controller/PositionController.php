<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Position;
use App\Form\Position\AddPositionType;
use App\Form\Position\EditPositionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PositionController extends AbstractController
{
    #[Route('/data/position/showAll', name: 'app_data_positions_show_all')]
    public function showAllPositions(EntityManagerInterface $entityManager): Response
    {
        //get positions array
        $positions = $entityManager
            ->getRepository(Position::class)
            ->findAll();

        return $this->render('data/position/showAll.html.twig', [
            'positions' => $positions
        ]);
    }

    #[Route('/data/position/add', name: 'app_data_positions_add')]
    public function addPosition(Request $request, EntityManagerInterface $entityManager): Response
    {
        $position = new Position();

        $form = $this->createForm(AddPositionType::class, $position);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($position);
            $entityManager->flush();

            return $this->redirectToRoute('app_data_positions_show_all');
        }

        return $this->render('data/position/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/data/position/edit/{positionId}', name: 'app_data_positions_edit')]
    public function editPosition(Request $request, EntityManagerInterface $entityManager, int $positionId): Response
    {
        //get positions array
        $position = $entityManager
            ->getRepository(Position::class)
            ->findOneById($positionId);

        $form = $this->createForm(EditPositionType::class, $position);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($position);
            $entityManager->flush();

            return $this->redirectToRoute('app_data_positions_show_all');
        }

        return $this->render('data/position/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
