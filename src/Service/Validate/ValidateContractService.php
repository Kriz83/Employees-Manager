<?php

declare(strict_types=1);

namespace App\Service\Validate;

use App\Entity\Contract;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManagerInterface;

class ValidateContractService
{
    private $em;
    private $vavalidationResponse;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function validate(Form $form, $employeeId): array
    {
        $contractId = 0;

        if (method_exists($form->getData(), 'getId')) {
            //avoid null values
            if ($form->getData()->getId()) {
                $contractId = $form->getData()->getId();
            }
        }

        //allow only one active contract
        if (isset($form['active'])) {
            $this->checkOtherActiveContracts(
                $form['active']->getData(),
                $contractId,
                $employeeId
            );
        }
        
        //avoid contracts in same time range
        if (isset($form['startDate']) && isset($form['stopDate'])) {
            
            if ($form['startDate'] && $form['stopDate']) {
                //start and stop date were passed
                $this->compareWithOtherContractsDates(
                    $form['startDate']->getData(),
                    $form['stopDate']->getData(),
                    $contractId,
                    $employeeId
                );
            }
        }

        return $this->validationResponse;
    }

    private function checkOtherActiveContracts(
        $active,
        $contractId,
        $employeeId
    ): void {
        //check if user have got other active contracts
        if ($active) {
            $isOtherActive = $this->em
                ->getRepository(Contract::class)
                ->findOneActiveByEmployeeId($contractId, $employeeId);
            
            if (!empty($isOtherActive)) {
                $this->validationResponse[] = 'There is other active contract for Employee. Disable other one to make this one active.';
            }
        }
    }

    private function compareWithOtherContractsDates(
        $startDate,
        $stopDate,
        $contractId,
        $employeeId
    ): void {
        $isOtherInDates = $this->em
            ->getRepository(Contract::class)
            ->getContractsInDatesRangeAndEmployeeId(
                $startDate,
                $stopDate,
                $contractId,
                $employeeId
            );

        if (!empty($isOtherInDates)) {
            $this->validationResponse[] = 'There is other contract in selected dates range.';
        }
    }

}    
    