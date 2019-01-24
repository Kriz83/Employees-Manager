<?php

namespace App\Controller;

use App\Entity\Position;
use App\Form\Position\AddPositionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddDataController extends AbstractController
{

    /**
     * @Route("/data/position/showAll", name="app_data_positions_show_all")
     */
    public function showAllPositions(EntityManagerInterface $em)
    {
        //get positions array
        $positions = $em
            ->getRepository('App:Position')
            ->findAll();
       
        return $this->render('data/position/showAll.html.twig', array(
            'positions' => $positions
        ));
    }

    /**
     * @Route("/data/position/add", name="app_data_positions_add")
     */
    public function addPosition(Request $request, EntityManagerInterface $em)
    {       
        $position = new Position();

        $form = $this->createForm(AddPositionType::class, $position);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($position);
            $em->flush();

            return $this->redirectToRoute('app_data_positions_show_all', array(
            ));
        }

        return $this->render('data/position/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
