<?php

namespace Luckyseven\Bundle\LuckysevenServicesBundle\Service;

use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Luckyseven\Bundle\LuckysevenServicesBundle\Entity\EntityService;
use Luckyseven\Bundle\LuckysevenServicesBundle\Entity\Service;
use Doctrine\ORM\EntityRepository;
use Luckyseven\Bundle\LuckysevenServicesBundle\Interface\IEntityHasServices;

class LuckysevenServicesService
{
    protected EntityRepository $serviceRepository;
    protected EntityRepository $entityServiceRepository;

    public function __construct(EntityManagerInterface $entityManager, string $serviceEntity)
    {
        $this->serviceRepository = $entityManager->getRepository($serviceEntity);
        $this->entityServiceRepository = $entityManager->getRepository(EntityService::class);
    }

    public function createService(Service $service, $flush = true): Service
    {
        $this->serviceRepository->save($service, $flush);
        return $service;
    }

    public function deleteService(Service $service, $flush = true): Service
    {
        $this->serviceRepository->remove($service, $flush);
        return $service;
    }

    public function getServices(?IEntityHasServices $entity = null): array
    {
        return $entity
            ? $this->serviceRepository->findForEntity($entity)
            : $this->serviceRepository->findAll();
    }

    public function getServiceById(int $serviceId): ?Service
    {
        return $this->serviceRepository->find($serviceId);
    }

    public function getAllRootServices(): array
    {
        return $this->serviceRepository->findAllWithoutParent();
    }

    public function addService(IEntityHasServices $entity, Service $service): Service
    {
        $this->entityServiceRepository->addService($entity, $service);
        return $service;
    }


    public function addServices(IEntityHasServices $entity, array $services): array
    {
        $this->entityServiceRepository->addServices($entity, $services);
        return $services;
    }

    public function removeService(IEntityHasServices $entity, Service $service): Service
    {
        $this->entityServiceRepository->removeService($entity, $service);
        return $service;
    }
}
