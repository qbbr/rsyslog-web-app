<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Helper\SearchQueryHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private const URI = '/api/latest';

    public function testLatest(): void
    {
        $client = static::createClient();
        $client->request('GET', self::URI);

        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $content = $response->getContent();
        $this->assertJson($content);
        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('results', $responseData);
        $firstRow = current($responseData['results']);
        $this->assertArrayHasKey('id', $firstRow);
        $this->assertArrayHasKey('date', $firstRow);
        $this->assertArrayHasKey('host', $firstRow);
        $this->assertArrayHasKey('message', $firstRow);
        $this->assertArrayHasKey('tag', $firstRow);
        $this->assertArrayHasKey('priorityName', $firstRow);
        $this->assertArrayHasKey('priorityBadgeBg', $firstRow);
        $this->assertArrayHasKey('facilityName', $firstRow);

        $this->assertArrayHasKey('page', $responseData);
        $this->assertArrayHasKey('pageSize', $responseData);
        $this->assertArrayHasKey('lastPage', $responseData);
        $this->assertArrayHasKey('total', $responseData);
        $this->assertArrayHasKey('filters', $responseData);
        $this->assertArrayHasKey(SearchQueryHelper::FILTER_OPERATOR_EQ, $responseData['filters']);
        $this->assertArrayHasKey(SearchQueryHelper::FILTER_OPERATOR_NEQ, $responseData['filters']);
    }
}
