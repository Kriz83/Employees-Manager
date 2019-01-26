<?php

namespace App\Controller;

use App\Entity\Factory;
use App\Form\Factory\AddFactoryType;
use App\Form\Factory\EditFactoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FactoryController extends AbstractController
{

    /**
     * @Route("/data/factory/showAll", name="app_data_factories_show_all")
     */
    public function showAllFactorys(EntityManagerInterface $em)
    {
        //get factories array
        $factories = $em
            ->getRepository('App:Factory')
            ->findAll();
       
        return $this->render('data/factory/showAll.html.twig', array(
            'factories' => $factories
        ));
    }

    /**
     * @Route("/data/factory/add", name="app_data_factories_add")
     */
    public function addFactory(Request $request, EntityManagerInterface $em)
    {       
        $factory = new Factory();

        $form = $this->createForm(AddFactoryType::class, $factory);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($factory);
            $em->flush();

            return $this->redirectToRoute('app_data_factories_show_all', array(
            ));
        }

        return $this->render('data/factory/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/data/factory/edit/{factoryId}", name="app_data_factories_edit")
     */
    public function editFactory(Request $request, EntityManagerInterface $em, $factoryId)
    {       
        //get factories array
        $factory = $em
            ->getRepository('App:Factory')
            ->findOneById($factoryId);

        $form = $this->createForm(EditFactoryType::class, $factory);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($factory);
            $em->flush();

            return $this->redirectToRoute('app_data_factories_show_all', array(
            ));
        }

        return $this->render('data/factory/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
