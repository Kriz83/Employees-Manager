<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $idDocumentNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $bornDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contract", mappedBy="employee")
     */
    private $contracts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getIdDocumentNumber(): ?string
    {
        return $this->idDocumentNumber;
    }

    public function setIdDocumentNumber(?string $idDocumentNumber): self
    {
        $this->idDocumentNumber = $idDocumentNumber;

        return $this;
    }

    public function getBornDate(): ?\DateTimeInterface
    {
        return $this->bornDate;
    }

    public function setBornDate(\DateTimeInterface $bornDate): self
    {
        $this->bornDate = $bornDate;

        return $this;
    }
}
