<?php


namespace App\Repository;


use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class AppointmentRepository extends EntityRepository
{

    /**
     * Returns Doctrine QueryBuilder with all $user's appointments descending by DateTime.
     *
     * @param User $user
     * @return QueryBuilder
     */
    public function getUserAppointmentsQueryBuilder(User $user)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->setParameter('user', $user)
            ->orderBy('p.date', 'DESC')
            ->addOrderBy('p.timeSlot', 'DESC');

        if ($user->getType() == User::USERTYPE_DOCTOR) {
            $col = 'doctor';
        } else {
            $col = 'patient';
        }
        $qb->where("p.$col = :user");

        return $qb;
    }

}