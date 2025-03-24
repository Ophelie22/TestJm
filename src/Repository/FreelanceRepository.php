<?php

namespace App\Repository;

use App\Entity\Freelance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends ServiceEntityRepository<Freelance>
 */
class FreelanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Freelance::class);
    }



#[ArrayShape(['firstName' => "string", 'quantity' => "int"])]
    public function findTheMostUseFirstname(): ?array
    {
        return $this->createQueryBuilder('f')
            ->join('f.freelanceConso', 'fc')
            ->select('fc.firstName AS firstname, COUNT(f.id) AS count')
            ->groupBy('fc.firstName')
            ->orderBy('count', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

