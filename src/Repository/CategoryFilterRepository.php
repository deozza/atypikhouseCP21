<?php

namespace App\Repository;

use App\Entity\CategoryFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoryFilter|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryFilter|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryFilter[]    findAll()
 * @method CategoryFilter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryFilterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoryFilter::class);
    }
}
