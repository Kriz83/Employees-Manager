<?php

namespace App\Controller;

use App\Entity\Employee;
use Psr\Log\LoggerInterface;
use App\Form\Employee\AddEmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeController extends AbstractController
{

    /**
     * @Route("/employee/add", name="app_employee_add")
     */
    public function addEmployee(Request $request, EntityManagerInterface $em)
    {

        $employee = new Employee();

        $form = $this->createForm(AddEmployeeType::class, $employee);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($employee);
            $em->flush();
            
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
    public function profile(
        LoggerInterface $logger,
        EntityManagerInterface $em,
        $employeeId
        )
    {

        $repository = $em->getRepository(Employee::class);
        $employee = $repository->findOneById($employeeId);

        if (!$employee) {
            $logger->warning(
                sprintf('Employee with id: %s, could not be found.', $id)
            );
            throw new NotFoundHttpException(
                sprintf('Employee with id: %s, could not be found.', $id)
            );
        }

        return $this->render('employee/profile/main.html.twig', [
            'employee' => $employee
        ]);
    }

}
