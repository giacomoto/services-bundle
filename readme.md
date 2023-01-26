# Luckyseven Services Bundle
Luckyseven Services Bundle

## Update composer.json and register the repositories
```
{
    ...
    "repositories": [
        {"type": "git", "url":  "https://github.com/giacomoto/services-bundle.git"}
    ],
    ...
    "extra": {
        "symfony": {
            ...
            "endpoint": [
                "https://api.github.com/repos/giacomoto/services-recipes/contents/index.json",
                "flex://defaults"
            ]
        }
    }
}
```

## Install
```
composer require symfony/orm-pack

composer require luckyseven/services:dev-main
composer recipes:install luckyseven/services --force -v
```

## Usage
Create the Entity `Service.php` to extend the bundle entity superclass.
```php
<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\Collection;
use Luckyseven\Bundle\LuckysevenServicesBundle\Entity\Service as L7Service;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service extends L7Service
{
    #[ORM\OneToMany(mappedBy: "parent", targetEntity: self::class)]
    protected Collection $children;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: "children")]
    #[ORM\JoinColumn(name: "parent_id", referencedColumnName: "id")]
    protected ?self $parent;

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function setParent(self $parent): self
    {
        return $this->parent = $parent;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }
}

```
Create the Repository `ServiceRespository.php` to extend the bundle repository
```php
<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Persistence\ManagerRegistry;
use Luckyseven\Bundle\LuckysevenServicesBundle\Repository\ServiceRepository as L7ServiceRepository;

class ServiceRepository extends L7ServiceRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }
}
```
Implements the interface `Luckyseven\Bundle\LuckysevenServicesBundle\Interface\IEntityHasServices` with the entity you want to support services

Lastly, `php bin/console make:migration`
