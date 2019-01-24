<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRepository")
 */
class Contract
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Factory", inversedBy="contracts")
     */
    private $factory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Position", inversedBy="contracts")
     */
    private $position;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $stopDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContractType", inversedBy="contracts")
     */
    private $contractType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="contracts")
     */
    private $employee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactory()
    {
        return $this->factory;
    }

    public function setFactory($factory): self
    {
        $this->factory = $factory;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position): self
    {
        $this->position = $position;

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

    public function getStopDate(): ?\DateTimeInterface
    {
        return $this->stopDate;
    }

    public function setStopDate(?\DateTimeInterface $stopDate): self
    {
        $this->stopDate = $stopDate;

        return $this;
    }

    public function getContractType()
    {
        return $this->contractType;
    }

    public function setContractType($contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getEmployee()
    {
        return $this->employee;
    }

    public function setEmployee($employee)
    {
        $this->employee = $employee;

        return $this;
    }

}
