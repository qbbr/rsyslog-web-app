<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SystemEvents;
use App\Helper\SearchQueryHelper;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SystemEvents>
 *
 * @method SystemEvents|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemEvents|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemEvents[]    findAll()
 * @method SystemEvents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemEventsRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, SystemEvents::class);
    }

    public function findLatest(
        int $page = 1,
        int $pageSize = Paginator::PAGE_SIZE,
        string $searchQuery = null,
    ): Paginator {
        $qb = $this->createQueryBuilder('e');

        if (null !== $searchQuery) {
            if ($filters = SearchQueryHelper::extractFilters($searchQuery)) {
                $qb->addCriteria(SearchQueryHelper::filtersToCriteria($filters));
            } elseif ($searchTerms = SearchQueryHelper::extractSearchTerms($searchQuery)) {
                $orStatements = $qb->expr()->orX();

                foreach ($searchTerms as $term) {
                    $orStatements->add(
                        $qb->expr()->like('e.message', $qb->expr()->literal('%'.$term.'%'))
                    );
                }

                $qb->andWhere($orStatements);
            }
        }

        $qb->addOrderBy('e.id', Criteria::DESC);

        return (new Paginator($qb, $pageSize, $filters ?? []))->paginate($page);
    }
}
