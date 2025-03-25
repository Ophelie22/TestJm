<?php

namespace App\Repository;

use App\Entity\FreelanceLinkedIn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FreelanceLinkedIn>
 */
class FreelanceLinkedInRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreelanceLinkedIn::class);
    }

}
