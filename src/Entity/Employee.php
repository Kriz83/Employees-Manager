<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $surname = null;

    #[ORM\Column(type: 'string', length: 255, name: 'id_document_number', unique: true)]
    private ?string $idDocumentNumber = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $bornDate = null;

    #[ORM\OneToMany(targetEntity: Contract::class, mappedBy: 'employee')]
    private Collection $contracts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
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

    public function setBornDate(?\DateTimeInterface $bornDate): self
    {
        $this->bornDate = $bornDate;
        return $this;
    }

    /**
     * @return Collection|Contract[]
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function setContracts(Collection $contracts): self
    {
        $this->contracts = $contracts;
        return $this;
    }
}
