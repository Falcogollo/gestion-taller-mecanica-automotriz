<?php

namespace App\Repository;

use App\Entity\OrdenDeTrabajo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrdenDeTrabajo>
 *
 * @method OrdenDeTrabajo|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdenDeTrabajo|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdenDeTrabajo[]    findAll()
 * @method OrdenDeTrabajo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdenDeTrabajoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdenDeTrabajo::class);
    }

    public function save(OrdenDeTrabajo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrdenDeTrabajo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OrdenDeTrabajo[] Returns an array of OrdenDeTrabajo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrdenDeTrabajo
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
