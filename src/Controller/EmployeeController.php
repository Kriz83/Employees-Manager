<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\Employee\AddEmployeeType;
use App\Form\Employee\EditEmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Validate\ValidateObjectExistenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeeController extends AbstractController
{

    public function __construct(
        ValidateObjectExistenceService $objectExistenceValidator,
        EntityManagerInterface $em
    ) {
        $this->objectExistenceValidator = $objectExistenceValidator;
        $this->em = $em;
    }

    /**
     * @Route("/employee/add", name="app_employee_add")
     */
    public function addEmployee(Request $request)
    {

        $employee = new Employee();

        $form = $this->createForm(AddEmployeeType::class, $employee);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($employee);
            $this->em->flush();
            
            return $this->redirectToRoute('app_employee_profile', array(
                'employeeId' => $employee->getId(),
            ));
        }
        
        return $this->render('employee/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/employee/profile/{employeeId}", name="app_employee_profile")
     */
    public function profile($employeeId)
    {

        $repository = $this->em->getRepository(Employee::class);
        $employee = $repository->findOneById($employeeId);

        //check if employee exist
        $this->objectExistenceValidator->validate($employee, $employeeId);

        return $this->render('employee/profile/main.html.twig', [
            'employee' => $employee
        ]);
    }

    /**
     * @Route("/employee/edit/{employeeId}", name="app_employee_edit")
     */
    public function edit(Request $request, $employeeId)
    {

        $repository = $this->em->getRepository(Employee::class);
        $employee = $repository->findOneById($employeeId);

        //check if employee exist
        $this->objectExistenceValidator->validate($employee, $employeeId);
        
        $form = $this->createForm(EditEmployeeType::class, $employee);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($employee);
            $this->em->flush();
            
            return $this->redirectToRoute('app_employee_profile', array(
                'employeeId' => $employee->getId(),
            ));
        }

        return $this->render('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

}
