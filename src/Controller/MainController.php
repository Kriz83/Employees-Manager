<?php

namespace App\Controller;

use App\Entity\Employee;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(LoggerInterface $logger)
    {
        $logger->info('Homepage Was visited');

        return $this->render('homepage/homepage.html.twig');
    }

}
