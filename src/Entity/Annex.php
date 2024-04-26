<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnnexRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnexRepository::class)]
class Annex implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $signDate = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $bidValue = null;

    #[ORM\ManyToOne(targetEntity: Contract::class, inversedBy: 'annex')]
    private ?Contract $contract = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignDate(): ?\DateTimeInterface
    {
        return $this->signDate;
    }

    public function setSignDate(?\DateTimeInterface $signDate): self
    {
        $this->signDate = $signDate;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getBidValue(): ?float
    {
        return $this->bidValue;
    }

    public function setBidValue(?float $bidValue): self
    {
        $this->bidValue = $bidValue;
        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;
        return $this;
    }
}
