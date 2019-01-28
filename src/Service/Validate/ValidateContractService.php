<?php

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
        $this->validationResponse = [];
    }
    
    public function validate(Form $form, $employeeId): array
    {
        //allow only one active contract
        if (isset($form['active'])) {
            $this->checkOtherActiveContracts($form['active']->getData(), $employeeId);
        }
        
        //avoid contracts in same time range
        if (isset($form['startDate']) && isset($form['stopDate'])) {
            
            $contractId = 0;
            if (isset($form['id'])) {
                $contractId = $form['id']->getData();
            }

            if ($form['startDate'] && $form['stopDate']) {
                //start and stop date were passed
                $this->compareWithOtherContractsDates($form['startDate']->getData(), $form['stopDate']->getData(), $contractId, $employeeId);                
            }
        }

        return $this->validationResponse;
    }

    private function checkOtherActiveContracts($active, $employeeId)
    {
        //check if user have got other active contracts
        if ($active) {
            $isOtherActive = $this->em->getRepository(Contract::class)->findOneActiveByEmployeeId($employeeId);
            if ($isOtherActive) {
                $this->validationResponse[] = 'There is other active contract for Employee. Disable other one to make this one active.';  
            }
        }

        return null;
    }

    private function compareWithOtherContractsDates($startDate, $stopDate, $contractId, $employeeId)
    {
        $isOtherInDates = $this->em->getRepository(Contract::class)->getContractsInDatesRangeAndEmployeeId($startDate, $stopDate, $contractId, $employeeId);
        if ($isOtherInDates) {
            $this->validationResponse[] = 'There is other contract in selected dates range.';  
        }

        return null;
    }

}    
    