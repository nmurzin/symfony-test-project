<?php

namespace App\Repository;

use App\Entity\DivisionTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DivisionTeam>
 */
class DivisionTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DivisionTeam::class);
    }

    public function findByTeam($team)
    {
        return $this->createQueryBuilder('dt')
            ->andWhere('dt.team = :team')
            ->setParameter('team', $team)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
