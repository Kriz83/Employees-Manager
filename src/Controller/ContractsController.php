<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contract;
use App\Form\Contract\AddContractType;
use App\Form\Contract\EditContractType;
use App\Repository\EmployeeRepository;
use App\Repository\FactoryRepository;
use App\Service\Contract\ContractService;
use App\Service\Contract\RemoveContractService;
use App\Service\Doctrine\ResourcePersister;
use App\Service\Validate\ValidateContractService;
use App\Service\Validate\ValidateObjectExistenceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContractsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ResourcePersister $resourcePersister,
        private EmployeeRepository $employeeRepository,
    ) {
    }

    #[Route('/contract/add/{employeeId}', name: 'app_contract_add')]
    public function addContract(Request $request, ContractService $contractService, int $employeeId): Response
    {
        $employee = $this->employeeRepository
            ->findOneById($employeeId);

        $contract = new Contract();

        $form = $this->createForm(AddContractType::class, $contract);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractService->addContract($contract, $form, $employeeId);

            $this->addFlash('success', 'New contract was added.');

            return $this->redirectToRoute('app_show_contracts', [
                'employeeId' => $employeeId
            ]);
        }

        return $this->render('contract/add.html.twig', [
            'form' => $form->createView(),
            'employee' => $employee
        ]);
    }

    #[Route('/showContracts/{employeeId}', name: 'app_show_contracts')]
    public function showContracts(int $employeeId): Response
    {
        $employee = $this->entityManager
            ->getRepository('App:Employee')
            ->findOneById($employeeId);

        $contracts = $this->entityManager
            ->getRepository('App:Contract')
            ->findByEmployee($employee);

        return $this->render('contract/show.html.twig', [
            'employee' => $employee,
            'contracts' => $contracts,
        ]);
    }

    #[Route('/contract/edit/{contractId}', name: 'app_contract_edit')]
    public function edit(Request $request, ContractService $contractService, int $contractId): Response
    {
        $repository = $this->entityManager->getRepository(Contract::class);
        $contract = $repository->findOneById($contractId);

        $employee = $contract->getEmployee();
        $employeeId = $employee->getId();

        $form = $this->createForm(EditContractType::class, $contract);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractService->editContract($contract, $form, $employeeId);

            $this->addFlash('success', 'Contract data was updated.');

            return $this->redirectToRoute('app_show_contracts', [
                'employeeId' => $employeeId,
            ]);
        }

        return $this->render('contract/edit.html.twig', [
            'contract' => $contract,
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contract/details/{contractId}', name: 'app_contract_details')]
    public function details(int $contractId): Response
    {
        $repository = $this->entityManager->getRepository(Contract::class);
        $contract = $repository->findOneById($contractId);

        $employee = $contract->getEmployee();

        return $this->render('contract/details.html.twig', [
            'contract' => $contract,
            'employee' => $employee,
        ]);
    }


    #[Route('/contract/remove/{contractId}', name: 'app_contract_remove')]
    public function remove(int $contractId): Response
    {
        $repository = $this->entityManager->getRepository(Contract::class);
        $contract = $repository->findOneById($contractId);

        $employee = $contract->getEmployee();
        $employeeId = $employee->getId();

        $this->resourcePersister->remove($contract);

        $this->addFlash('warning', 'Contract data and related anexxes were removed.');

        return $this->redirectToRoute('app_show_contracts', [
            'employeeId' => $employeeId,
        ]);

    }

}
