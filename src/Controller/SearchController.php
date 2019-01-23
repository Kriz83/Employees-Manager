<?php

namespace App\Controller;

use App\Service\Search\SearchEmployeesService;
use App\Form\Employee\SearchForEmployeesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{

    /**
     * @Route("/search/contracts", name="app_search_contracts")
     */
    public function searchContracts()
    {
        return $this->render('search/contracts.html.twig');
    }

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
    public function showSearchedEmployees(Request $request)
    {
        $entityManeger = $this->getDoctrine()->getManager();

        $searchedIdsData = $request->query->get('searchedIdsData');
      
        //get employees array
        $employees = $entityManeger
            ->getRepository('App:Employee')
            ->getEmployeesByIdsArray($searchedIdsData);
        
        return $this->render('search\eployees\showSearchResult.html.twig', array(
            'employees' => $employees,
        ));
    }

}