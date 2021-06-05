<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class UserRepository extends EntityRepository
{

    /**
     * Returns Doctrine QueryBuilder with all users with descending createdAt.
     *
     * @return QueryBuilder
     */
    public function getAllQueryBuilder()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->orderBy('u.createdAt', 'DESC');

        return $qb;
    }

}