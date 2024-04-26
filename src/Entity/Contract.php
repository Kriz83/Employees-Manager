<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Factory::class, inversedBy: 'contracts')]
    private $factory;

    #[ORM\ManyToOne(targetEntity: Position::class, inversedBy: 'contracts')]
    private $position;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $stopDate = null;

    #[ORM\ManyToOne(targetEntity: ContractType::class, inversedBy: 'contracts')]
    private $contractType;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'contracts')]
    private $employee;

    #[ORM\Column(type: 'boolean')]
    private bool $active = false;

    #[ORM\OneToMany(targetEntity: Annex::class, mappedBy: 'contract')]
    private $annex;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $signDate = null;

    #[ORM\Column(type: 'float')]
    private ?float $bidValue = null;

    public function __construct()
    {
        $this->annex = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactory(): ?Factory
    {
        return $this->factory;
    }

    public function setFactory(?Factory $factory): self
    {
        $this->factory = $factory;
        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;
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

    public function getStopDate(): ?\DateTimeInterface
    {
        return $this->stopDate;
    }

    public function setStopDate(?\DateTimeInterface $stopDate): self
    {
        $this->stopDate = $stopDate;
        return $this;
    }

    public function getContractType(): ?ContractType
    {
        return $this->contractType;
    }

    public function setContractType(?ContractType $contractType): self
    {
        $this->contractType = $contractType;
        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;
        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return Collection|Annex[]
     */
    public function getAnnex(): Collection
    {
        return $this->annex;
    }

    public function addAnnex(Annex $annex): self
    {
        if (!$this->annex->contains($annex)) {
            $this->annex[] = $annex;
            $annex->setContract($this);
        }
        return $this;
    }

    public function removeAnnex(Annex $annex): self
    {
        if ($this->annex->removeElement($annex)) {
            // set the owning side to null (unless already changed)
            if ($annex->getContract() === $this) {
                $annex->setContract(null);
            }
        }
        return $this;
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

    public function getBidValue(): ?float
    {
        return $this->bidValue;
    }

    public function setBidValue(?float $bidValue): self
    {
        $this->bidValue = $bidValue;
        return $this;
    }
}
