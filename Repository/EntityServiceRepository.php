<?php

namespace Luckyseven\Bundle\LuckysevenServicesBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Luckyseven\Bundle\LuckysevenServicesBundle\Entity\EntityService;
use Luckyseven\Bundle\LuckysevenServicesBundle\Entity\Service;
use Luckyseven\Bundle\LuckysevenServicesBundle\Interface\IEntityHasServices;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method EntityService|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityService|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityService[]    findAll()
 * @method EntityService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityService::class);
    }

    public function save(EntityService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EntityService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function addService(IEntityHasServices $entity, Service $service): void
    {
        $sql = <<<SQL
            INSERT IGNORE INTO {$this->getClassMetadata()->getTableName()}
            (`service_id`, `reference_id`, `reference_table`)
            VALUES (?, ?, ?) 
        SQL;

        $this->getEntityManager()->getConnection()->executeQuery($sql, [
            $service->getId(),
            $entity->getId(),
            $entity::class,
        ]);
    }

    public function addServices(IEntityHasServices $entity, array $services): void
    {
        $values = implode(',', array_map(static fn() => '(?, ?, ?)', $services));
        $params = [];

        $sql = <<<SQL
            INSERT IGNORE INTO {$this->getClassMetadata()->getTableName()}
            (`service_id`, `reference_id`, `reference_table`)
            VALUES {$values} 
        SQL;

        foreach($services as $service) {
            $params[] = $service->getId();
            $params[] = $entity->getId();
            $params[] = $entity::class;
        }

        $this->getEntityManager()->getConnection()->executeQuery($sql, $params);
    }

    public function removeService(IEntityHasServices $entity, Service $service): void
    {
        $sql = <<<SQL
            DELETE FROM {$this->getClassMetadata()->getTableName()}
            WHERE `service_id` = ? AND `reference_id` = ? AND `reference_table` = ? 
        SQL;

        $this->getEntityManager()->getConnection()->executeQuery($sql, [
            $service->getId(),
            $entity->getId(),
            $entity::class,
        ]);
    }
}
