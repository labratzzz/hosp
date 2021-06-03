<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{

    public function getPostQueryBuilder()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy('p.createdAt', 'DESC');

        return $qb;
    }

}