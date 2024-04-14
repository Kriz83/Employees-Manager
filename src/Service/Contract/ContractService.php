<?php

declare(strict_types=1);

namespace App\Service\Contract;

use App\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class ContractService
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addContract(
        Contract $contract,
        FormInterface $form,
        int $employeeId
    ): void {
        $employee = $this->em
            ->getRepository('App:Employee')
            ->findOneById($employeeId);

        $factory = $this->em
            ->getRepository('App:Factory')
            ->findOneById($form['factory']->getData());

        $position = $this->em
            ->getRepository('App:Position')
            ->findOneById($form['position']->getData());

        $contractType = $this->em
            ->getRepository('App:ContractType')
            ->findOneById($form['contractType']->getData());

        $contract->setEmployee($employee);
        $contract->setPosition($position);
        $contract->setFactory($factory);
        $contract->setContractType($contractType);
        $contract->setBidValue($form['bidValue']->getData());
        $contract->setStartDate($form['startDate']->getData());
        $contract->setStopDate($form['stopDate']->getData());
        $contract->setSignDate($form['signDate']->getData());

        $this->em->persist($contract);
        $this->em->flush();
    }

    public function editContract(
        Contract $contract,
        FormInterface $form,
        int $employeeId
    ): void {
        $employee = $this->em
            ->getRepository('App:Employee')
            ->findOneById($employeeId);

        $factory = $this->em
            ->getRepository('App:Factory')
            ->findOneById($form['factory']->getData());

        $position = $this->em
            ->getRepository('App:Position')
            ->findOneById($form['position']->getData());

        $contractType = $this->em
            ->getRepository('App:ContractType')
            ->findOneById($form['contractType']->getData());

        $contract->setEmployee($employee);
        $contract->setPosition($position);
        $contract->setFactory($factory);
        $contract->setContractType($contractType);
        $contract->setBidValue($form['bidValue']->getData());
        $contract->setStartDate($form['startDate']->getData());
        $contract->setStopDate($form['stopDate']->getData());
        $contract->setSignDate($form['signDate']->getData());
        $contract->setActive($form['active']->getData());

        $this->em->persist($contract);
        $this->em->flush();
    }
}