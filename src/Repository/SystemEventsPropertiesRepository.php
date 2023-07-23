<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SystemEventsProperties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SystemEventsProperties>
 *
 * @method SystemEventsProperties|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemEventsProperties|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemEventsProperties[]    findAll()
 * @method SystemEventsProperties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemEventsPropertiesRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, SystemEventsProperties::class);
    }
}
