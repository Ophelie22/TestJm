<?php

namespace App\Repository;

use App\Entity\FreelanceConso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FreelanceConso>
 */
class FreelanceConsoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreelanceConso::class);
    }


        public function findAll(): array
        {
            $result = $this->createQueryBuilder('f')
                ->getQuery()
                ->getResult();
            return $result;
        }
        
    }