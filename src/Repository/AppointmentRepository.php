<?php


namespace App\Repository;


use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class PostRepository extends EntityRepository
{

    /**
     * Returns Doctrine QueryBuilder with all posts with descending createdAt.
     *
     * @return QueryBuilder
     */
    public function getAllQueryBuilder()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy('p.createdAt', 'DESC');

        return $qb;
    }

    /**
     * Returns Doctrine QueryBuilder with all posts by passed $user with descending createdAt.
     *
     * @param User $user
     * @return QueryBuilder
     */
    public function getUserPostsQueryBuilder(User $user)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.author = :author')
            ->setParameter('author', $user)
            ->orderBy('p.createdAt', 'DESC');

        return $qb;
    }

}