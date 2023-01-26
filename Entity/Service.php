<?php

namespace Luckyseven\Bundle\LuckysevenServicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $icon = null;

    #[ORM\Column(length: 255)]
    protected ?string $label = null;

    #[ORM\Column(type: 'smallint', options: ['unsigned' => true])]
    protected ?string $sort = null;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }
}
