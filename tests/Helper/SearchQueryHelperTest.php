<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Enum\Priority;
use App\Helper\SearchQueryHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SearchQueryHelperTest extends TestCase
{
    #[DataProvider(methodName: 'searchTermsProvider')]
    public function testExtractSearchTerms($expected, $actual): void
    {
        $this->assertSame($expected, $actual);
    }

    #[DataProvider(methodName: 'extractFiltersProvider')]
    public function testExtractFilters($expected, $actual): void
    {
        $this->assertSame($expected, $actual);
    }

    public static function searchTermsProvider(): array
    {
        return [
            [['quoted phrase'], SearchQueryHelper::extractSearchTerms('"quoted phrase"')],
            [['term'], SearchQueryHelper::extractSearchTerms('term')],
            [['term1', 'term2'], SearchQueryHelper::extractSearchTerms('term1 term2')],
        ];
    }

    public static function extractFiltersProvider(): array
    {
        return [
            [
                [
                    SearchQueryHelper::FILTER_OPERATOR_EQ => ['host' => ['SRV1']],
                ],
                SearchQueryHelper::extractFilters(
                    \sprintf('host %s "SRV1"', SearchQueryHelper::FILTER_OPERATOR_EQ),
                ),
            ],
            [
                [
                    SearchQueryHelper::FILTER_OPERATOR_EQ => ['h' => ['SRV1'], 'p' => [Priority::warn->name]],
                ],
                SearchQueryHelper::extractFilters(
                    \sprintf(
                        'h %1$s "SRV1", p %1$s"%2$s"',
                        SearchQueryHelper::FILTER_OPERATOR_EQ,
                        Priority::warn->name,
                    )
                ),
            ],
            [
                [
                    SearchQueryHelper::FILTER_OPERATOR_NEQ => ['host' => ['SRV1']],
                ],
                SearchQueryHelper::extractFilters(
                    \sprintf(
                        'host %s"SRV1"',
                        SearchQueryHelper::FILTER_OPERATOR_NEQ,
                    )
                ),
            ],
            [
                [
                    SearchQueryHelper::FILTER_OPERATOR_EQ => ['h' => ['SRV1'], 'p' => [Priority::warn->name]],
                    SearchQueryHelper::FILTER_OPERATOR_NEQ => ['t' => ['kernel:']],
                ],
                SearchQueryHelper::extractFilters(
                    \sprintf(
                        'h %1$s "SRV1",p%1$s"%3$s", t%2$s "kernel:"',
                        SearchQueryHelper::FILTER_OPERATOR_EQ,
                        SearchQueryHelper::FILTER_OPERATOR_NEQ,
                        Priority::warn->name,
                    )
                ),
            ],
            [
                [
                    SearchQueryHelper::FILTER_OPERATOR_EQ => ['host' => ['SRV1', 'DNS1']],
                ],
                SearchQueryHelper::extractFilters(
                    \sprintf(
                        'host %s"SRV1, DNS1"',
                        SearchQueryHelper::FILTER_OPERATOR_EQ,
                    )
                ),
            ],
        ];
    }
}
