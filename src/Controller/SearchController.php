<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Form\Contract\SearchForContractsType;
use App\Form\Employee\SearchForEmployeesType;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Search\SearchContractsService;
use App\Service\Search\SearchEmployeesService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/employees", name="app_search_employees")
     */
    public function searchEmployees(Request $request, SearchEmployeesService $searchEmployees)
    {
        $form = $this->createForm(SearchForEmployeesType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //create search class (service)
            $searchedIdsData = $searchEmployees->search($form);

            return $this->redirectToRoute('app_search_employees_show', array(
                'searchedIdsData' => $searchedIdsData,
            ));
        }

        return $this->render('search\eployees\search.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/search/employees/show", name="app_search_employees_show")
     */
    public function showSearchedEmployees(Request $request, EntityManagerInterface $em)
    {
        $searchedIdsData = $request->query->get('searchedIdsData');
      
        //get employees array
        $employees = $em
            ->getRepository('App:Employee')
            ->getEmployeesByIdsArray($searchedIdsData);
        
        return $this->render('search\eployees\showSearchResult.html.twig', array(
            'employees' => $employees,
        ));
    }

    /**
     * @Route("/search/contracts", name="app_search_contracts")
     */
    public function searchContracts(Request $request, SearchContractsService $searchContracts)
    {
        
        $form = $this->createForm(SearchForContractsType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //create search class (service)
            $searchedIdsData = $searchContracts->search($form);
            
            return $this->redirectToRoute('app_search_contracts_show', array(
                'searchedIdsData' => $searchedIdsData,
            ));
        }
        
        return $this->render('search\contracts\search.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/search/contracts/show", name="app_search_contracts_show")
     */
    public function showSearchedContracts(Request $request, EntityManagerInterface $em)
    {
        $searchedIdsData = $request->query->get('searchedIdsData');
      
        //get contracts array
        $contracts = $em
            ->getRepository('App:Contract')
            ->getContractsByIdsArray($searchedIdsData);
        
        return $this->render('search\contracts\showSearchResult.html.twig', array(
            'contracts' => $contracts,
        ));
    }

}