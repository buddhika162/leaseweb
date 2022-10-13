<?php

namespace App\Repository;

use App\Entity\RamModule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RamModule>
 *
 * @method RamModule|null find($id, $lockMode = null, $lockVersion = null)
 * @method RamModule|null findOneBy(array $criteria, array $orderBy = null)
 * @method RamModule[]    findAll()
 * @method RamModule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RamModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RamModule::class);
    }

    public function save(RamModule $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RamModule $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return RamModule[] Returns an array of RamModule objects
     */
    public function getAll(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return integer[] Returns an array of RamModule ids
     */
    public function getAllRamModuleIds(): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.id')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SCALAR_COLUMN);
    }

//    public function findOneBySomeField($value): ?RamModule
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
