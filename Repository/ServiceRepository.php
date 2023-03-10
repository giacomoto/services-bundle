<?php

namespace Luckyseven\Bundle\LuckysevenServicesBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Luckyseven\Bundle\LuckysevenServicesBundle\Entity\EntityService;
use Luckyseven\Bundle\LuckysevenServicesBundle\Interface\IEntityHasServices;
use Luckyseven\Bundle\LuckysevenServicesBundle\Interface\IService;

/**
 * @extends ServiceEntityRepository<IService>
 *
 * @method IService|null find($id, $lockMode = null, $lockVersion = null)
 * @method IService|null findOneBy(array $criteria, array $orderBy = null)
 * @method IService[]    findAll()
 * @method IService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function save(IService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(IService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findForEntity(IEntityHasServices $entity): array
    {
        return $this->createQueryBuilder('s')
            ->select('s')
            ->leftJoin(EntityService::class, 'es', 'with', 'es.serviceId = s.id')
            ->andWhere('es.referenceId = :referenceId')
            ->andWhere('es.referenceTable = :referenceTable')
            ->setParameters([
                'referenceId' => $entity->getId(),
                'referenceTable' => $entity::class,
            ])
            ->getQuery()
            ->getResult();
    }

    public function findAllWithoutParent(): array
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata($this->getClassName(), 's');

        $sql = <<<SQL
            SELECT s.* FROM {$this->getClassMetadata()->getTableName()} s
            WHERE s.parent_id IS NULL
        SQL;

        return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getResult();
    }
}
