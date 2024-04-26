<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Contract\SearchForContractsType;
use App\Form\Employee\SearchForEmployeesType;
use App\Repository\ContractRepository;
use App\Repository\EmployeeRepository;
use App\Service\Search\SearchContractsService;
use App\Service\Search\SearchEmployeesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    public function __construct(
        private SearchContractsService $searchContractsService,
        private SearchEmployeesService $searchEmployeesService,
        private EmployeeRepository $employeeRepository,
        private ContractRepository $contractRepository,
    ) {
    }

    #[Route('/search/employees', name: 'app_search_employees')]
    public function searchEmployees(Request $request): Response
    {
        $form = $this->createForm(SearchForEmployeesType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_search_employees_show', [
                'searchedIdsData' => $this->searchEmployeesService->search($form),
            ]);
        }

        return $this->render('search/eployees/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search/employees/show', name: 'app_search_employees_show')]
    public function showSearchedEmployees(Request $request): Response
    {
        $searchedIdsData = $request->query->get('searchedIdsData');

        return $this->render('search/eployees/showSearchResult.html.twig', [
            'employees' => $this->employeeRepository->getEmployeesByIdsArray($searchedIdsData),
        ]);
    }

    #[Route('/search/contracts', name: 'app_search_contracts')]
    public function searchContracts(Request $request): Response
    {
        $form = $this->createForm(SearchForContractsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchedIdsData = $this->searchContractsService->search($form);

            return $this->redirectToRoute('app_search_contracts_show', [
                'searchedIdsData' => $searchedIdsData,
            ]);
        }

        return $this->render('search/contracts/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search/contracts/show', name: 'app_search_contracts_show')]
    public function showSearchedContracts(Request $request): Response
    {
        $searchedIdsData = $request->query->get('searchedIdsData');

        //get contracts array
        $contracts = $this->contractRepository
            ->getContractsByIdsArray($searchedIdsData);

        return $this->render('search/contracts/showSearchResult.html.twig', [
            'contracts' => $contracts,
        ]);
    }
}
