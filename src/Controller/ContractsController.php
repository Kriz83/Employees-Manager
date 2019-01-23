<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContractsController extends AbstractController
{

    /**
     * @Route("/showContracts", name="app_show_contracts")
     */
    public function showContracts()
    {
        return $this->render('homepage/homepage.html.twig');
    }

}