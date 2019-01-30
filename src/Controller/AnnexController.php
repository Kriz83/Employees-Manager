<?php

namespace App\Controller;

use App\Entity\Annex;
use App\Entity\Contract;
use App\Form\Annex\AddAnnexType;
use App\Service\Annex\AnnexService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Validate\ValidateObjectExistenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AnnexController extends AbstractController
{
    public function __construct(
        ValidateObjectExistenceService $objectExistenceValidator,
        AnnexService $annexService,
        EntityManagerInterface $em
    ) {
        $this->objectExistenceValidator = $objectExistenceValidator;
        $this->annexService = $annexService;
        $this->em = $em;
    }

    /**
     * @Route("/annex/add/{contractId}", name="app_annex_add")
     */
    public function addAnnex(Request $request, $contractId)
    {
        $repository = $this->em->getRepository(Contract::class);
        $contract = $repository->findOneById($contractId);

        //check if contract exist
        $this->objectExistenceValidator->validate($contract, $contractId);
        
        //get employee data
        $employee = $contract->getEmployee();
        $employeeId = $employee->getId();
        
        $annex = new Annex();

        $form = $this->createForm(AddAnnexType::class, $annex);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //add annex for contract
            $this->annexService->addAnnex($contract, $annex, $form);
                        
            $this->addFlash('success', 'New annex was added.');

            return $this->redirectToRoute('app_contract_details', array(
                'contractId' => $contractId                
            ));
        }

        return $this->render('annex/add.html.twig', [
            'form' => $form->createView(),
            'employee' => $employee
        ]);

    }

}
