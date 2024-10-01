<?php

declare(strict_types=1);

namespace App\Helper;

use App\Enum\Facility;
use App\Enum\Priority;
use Doctrine\Common\Collections\Criteria;

class SearchQueryHelper
{
    private const FILTER_MAP = [
        'host' => 'fromHost',
        'h' => 'fromHost',
        'f' => 'facility',
        'tag' => 'sysLogTag',
        't' => 'sysLogTag',
        'p' => 'priority',
    ];

    public const FILTER_OPERATOR_EQ = '=';
    public const FILTER_OPERATOR_NEQ = '!=';

    private const OPERATOR_MAP = [
        self::FILTER_OPERATOR_EQ => 'in',
        self::FILTER_OPERATOR_NEQ => 'notIn',
    ];

    public static function extractSearchTerms(
        string $searchQuery,
    ): array {
        if (str_starts_with($searchQuery, '"')) { // if "quoted phrase", do not separate to terms
            return [str_replace('"', '', $searchQuery)];
        }

        $terms = array_unique(explode(' ', preg_replace('/\s+/', ' ', trim($searchQuery))));

        // ignore the search terms that are too short
        return array_filter($terms, fn ($term) => 2 <= mb_strlen($term));
    }

    public static function extractFilters(
        string $searchQuery,
    ): array {
        $filters = [];

        if (preg_match_all('/(\w+) ?(!?=) ?"([^"]+)"/', $searchQuery, $matches, \PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $field = lcfirst($match[1]);
                $operator = $match[2];
                $value = $match[3];
                $filters[$operator][$field] = self::extractValues($value);
            }
        }

        return $filters;
    }

    public static function filtersToCriteria(
        array $filters,
    ): Criteria {
        $criteria = Criteria::create();

        foreach ($filters as $operator => $data) {
            foreach ($data as $field => $values) {
                if (isset(self::FILTER_MAP[$field])) { // alias to fullname
                    $field = self::FILTER_MAP[$field];
                }

                foreach ($values as &$value) {
                    $value = match ($field) { // named value to numeric
                        'facility' => Facility::tryFromName($value)->value,
                        'priority' => Priority::tryFromName($value)->value,
                        default => $value,
                    };
                }

                $criteria->andWhere(Criteria::expr()->{self::OPERATOR_MAP[$operator]}($field, $values));
            }
        }

        return $criteria;
    }

    private static function extractValues(
        string $values,
    ): array {
        return array_map('trim', explode(',', $values));
    }
}
