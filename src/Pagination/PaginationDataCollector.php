<?php

declare(strict_types=1);

namespace App\Pagination;

use App\Config;
use Symfony\Component\Serializer\Context\Normalizer\DateTimeNormalizerContextBuilder;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

readonly class PaginationDataCollector
{
    public function __construct(
        private NormalizerInterface $normalizer,
    ) {
    }

    public function getData(Paginator $paginator): array
    {
        $results = $paginator->getResults();

        $contextBuilder = (new ObjectNormalizerContextBuilder())
            ->withGroups(Config::GROUP_API);

        $contextBuilder = (new DateTimeNormalizerContextBuilder())
            ->withContext($contextBuilder)
            ->withFormat(Config::DATE_TIME_FORMAT);

        return [
            'results' => $this->normalizer->normalize($results, context: $contextBuilder->toArray()),
            'page' => $paginator->getCurrentPage(),
            'pageSize' => $paginator->getPageSize(),
            'lastPage' => $paginator->getLastPage(),
            'total' => $paginator->getTotal(),
            'filters' => $paginator->getFilters(),
        ];
    }
}
