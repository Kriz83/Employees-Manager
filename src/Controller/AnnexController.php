<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Annex;
use App\Entity\Contract;
use App\Form\Annex\AddAnnexType;
use App\Service\Annex\AnnexService;
use App\Service\Validate\ValidateObjectExistenceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnexController extends AbstractController
{
    public function __construct(
        private AnnexService $annexService,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/annex/add/{contractId}', name: 'app_annex_add')]
    public function addAnnex(Request $request, int $contractId): Response
    {
        $repository = $this->entityManager->getRepository(Contract::class);
        $contract = $repository->findOneById($contractId);

        $employee = $contract->getEmployee();

        $annex = new Annex();

        $form = $this->createForm(AddAnnexType::class, $annex);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->annexService->addAnnex($contract, $annex, $form);

            $this->addFlash('success', 'New annex was added.');

            return $this->redirectToRoute('app_contract_details', [
                'contractId' => $contractId
            ]);
        }

        return $this->render('annex/add.html.twig', [
            'form' => $form->createView(),
            'employee' => $employee
        ]);
    }
}
