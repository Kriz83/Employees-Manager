<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnexRepository")
 */
class Annex
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $signDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $bidValue;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contract", inversedBy="annex")
     */
    private $contract;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignDate(): ?\DateTimeInterface
    {
        return $this->signDate;
    }

    public function setSignDate(\DateTimeInterface $signDate): self
    {
        $this->signDate = $signDate;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
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

    public function getContract()
    {
        return $this->contract;
    }

    public function setContract($contract): self
    {
        $this->contract = $contract;

        return $this;
    }
}
