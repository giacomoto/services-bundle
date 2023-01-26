<?php

namespace Luckyseven\Bundle\LuckysevenServicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Luckyseven\Bundle\LuckysevenServicesBundle\Repository\EntityServiceRepository;

#[ORM\Entity(repositoryClass: EntityServiceRepository::class)]
#[ORM\UniqueConstraint(name: "unique_service_for_reference", columns: ["service_id", 'reference_id', 'reference_table'], options: [])]
class EntityService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $referenceTable = null;

    #[ORM\Column(length: 255)]
    protected ?string $referenceId = null;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    protected ?int $serviceId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferenceTable(): ?string
    {
        return $this->referenceTable;
    }

    public function setReferenceTable(string $referenceTable): self
    {
        $this->referenceTable = $referenceTable;

        return $this;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    public function setReferenceId(string $referenceId): self
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    public function getServiceId(): ?int
    {
        return $this->serviceId;
    }

    public function setServiceId(int $serviceId): self
    {
        $this->serviceId = $serviceId;

        return $this;
    }
}
