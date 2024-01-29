<?php

namespace App\Repository;

use App\Entity\Division;
use App\Entity\DivisionTeam;
use App\Entity\Team;
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

    public function findByTeam(Team $team)
    {
        return $this->createQueryBuilder('dt')
            ->andWhere('dt.team = :team')
            ->setParameter('team', $team)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return DivisionTeam[]
     */
    public function getDivisionTopFour(Division $division): array
    {
        $t = $this->createQueryBuilder('dt')
            ->andWhere('dt.division = :division')
            ->setParameter('division', $division)
            ->add('orderBy', 'dt.points DESC, dt.team ASC')
//            ->add('orderBy', 'dt.points DESC')
            ->setFirstResult( 0 )
            ->setMaxResults( 4 )
            ->getQuery();
        ;

        return $t->getResult();
    }
}
