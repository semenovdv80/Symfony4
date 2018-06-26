<?php

namespace App\Repository;

use App\Entity\Tender;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tender|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tender|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tender[]    findAll()
 * @method Tender[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TenderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tender::class);
    }

    /**
     * Get count of today tenders
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTodayTendersCount()
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            //->andWhere('t.closeDate >= :close_date')
            //->setParameter('close_date', Carbon::now())
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function getTodayTendersSum()
    {
        return $this->createQueryBuilder('t')
            ->select("sum(t.amount) as sum_amount")
            ->getQuery()
            ;
    }

    public function getTopTenders()
    {
        return $this->createQueryBuilder('t')
            ->select('t.nameRu', 'l.id AS lot_id')
            ->leftJoin('t.lots', 'l')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Tender[] Returns an array of Tender objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tender
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
