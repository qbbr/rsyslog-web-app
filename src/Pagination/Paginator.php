<?php

declare(strict_types=1);

namespace App\Pagination;

use App\Config;
use App\Helper\SearchQueryHelper;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class Paginator
{
    private int $currentPage;
    private \Traversable $results;
    private int $total;

    public function __construct(
        private readonly QueryBuilder $queryBuilder,
        private readonly int $pageSize = Config::PAGE_SIZE,
        private array $filters = [], // todo@qbbr: n to fix
    ) {
    }

    public function paginate(
        int $page = 1,
    ): self {
        $this->currentPage = max(1, $page);
        $firstResult = ($this->currentPage - 1) * $this->pageSize;

        $query = $this->queryBuilder
            ->setFirstResult($firstResult)
            ->setMaxResults($this->pageSize)
            ->getQuery();

        $paginator = new DoctrinePaginator($query, false);

        $this->results = $paginator->getIterator();
        $this->total = $paginator->count();

        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return (int) ceil($this->total / $this->pageSize);
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getResults(): \Traversable
    {
        return $this->results;
    }

    public function getFilters(): array
    {
        if (empty($this->filters[SearchQueryHelper::FILTER_OPERATOR_EQ])) {
            $this->filters[SearchQueryHelper::FILTER_OPERATOR_EQ] = [];
        }

        if (empty($this->filters[SearchQueryHelper::FILTER_OPERATOR_NEQ])) {
            $this->filters[SearchQueryHelper::FILTER_OPERATOR_NEQ] = [];
        }

        return $this->filters;
    }
}
