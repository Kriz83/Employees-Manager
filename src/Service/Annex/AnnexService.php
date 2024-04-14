<?php

declare(strict_types=1);

namespace App\Service\Annex;

use App\Entity\Annex;
use App\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class AnnexService
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addAnnex(
        Contract $contract,
        Annex $annex,
        FormInterface $form
    ): void {
        $annex->setContract($contract);
        $annex->setBidValue($form['bidValue']->getData());
        $annex->setStartDate($form['startDate']->getData());
        $annex->setSignDate($form['signDate']->getData());

        $this->em->persist($annex);
        $this->em->flush();
    }

}