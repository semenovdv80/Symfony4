<?php

namespace App\Repository;

use App\Entity\User;
use App\Helper\PageHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function adminUserList($request)
    {
        $order_col = $request->attributes->get('order_col');
        $order_type = $request->attributes->get('order_type') ?? 'desc';
        $rowsPerPage = $request->query->get('rowsPerPage') ?? 25;

        switch ($order_col) {
            case 'id': case 'email': case 'username':
                $order_col = 'u.'.$order_col;
                break;
            default:
                $order_col = 'u.id';
        }

        $query = $this->createQueryBuilder('u');

        if ($request->get('quickSearch')) {
            $value = trim($request->get('quickSearch'));
            $query->where($query->expr()->orX(
                $query->expr()->eq('u.id', ':val'),
                $query->expr()->eq('u.email', ':val'),
                $query->expr()->eq('u.username', ':val')
            ));
            $query->setParameter('val', $value);
        }

        $query->orderBy($order_col, $order_type)->getQuery();

        return PageHelper::paginate($query, $request, $rowsPerPage);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
