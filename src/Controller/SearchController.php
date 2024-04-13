<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Contract\SearchForContractsType;
use App\Form\Employee\SearchForEmployeesType;
use App\Service\Search\SearchContractsService;
use App\Service\Search\SearchEmployeesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search/employees', name: 'app_search_employees')]
    public function searchEmployees(Request $request, SearchEmployeesService $searchEmployees): Response
    {
        $form = $this->createForm(SearchForEmployeesType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //create search class (service)
            $searchedIdsData = $searchEmployees->search($form);

            return $this->redirectToRoute('app_search_employees_show', [
                'searchedIdsData' => $searchedIdsData,
            ]);
        }

        return $this->render('search/employees/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search/employees/show', name: 'app_search_employees_show')]
    public function showSearchedEmployees(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchedIdsData = $request->query->get('searchedIdsData');

        //get employees array
        $employees = $entityManager
            ->getRepository('App:Employee')
            ->getEmployeesByIdsArray($searchedIdsData);

        return $this->render('search/employees/showSearchResult.html.twig', [
            'employees' => $employees,
        ]);
    }

    #[Route('/search/contracts', name: 'app_search_contracts')]
    public function searchContracts(Request $request, SearchContractsService $searchContracts): Response
    {
        $form = $this->createForm(SearchForContractsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //create search class (service)
            $searchedIdsData = $searchContracts->search($form);

            return $this->redirectToRoute('app_search_contracts_show', [
                'searchedIdsData' => $searchedIdsData,
            ]);
        }

        return $this->render('search/contracts/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search/contracts/show', name: 'app_search_contracts_show')]
    public function showSearchedContracts(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchedIdsData = $request->query->get('searchedIdsData');

        //get contracts array
        $contracts = $entityManager
            ->getRepository('App:Contract')
            ->getContractsByIdsArray($searchedIdsData);

        return $this->render('search/contracts/showSearchResult.html.twig', [
            'contracts' => $contracts,
        ]);
    }
}
