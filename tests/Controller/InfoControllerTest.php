<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Service\Helper\DbHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoControllerTest extends WebTestCase
{
    private const URI = '/api/info';

    public function testInfo(): void
    {
        $client = static::createClient();

        $dbHelperService = $this->createMock(DbHelper::class);
        $dbHelperService->expects(self::once())
            ->method('getVersion')
            ->willReturn('3.41.2');
        self::getContainer()->set(DbHelper::class, $dbHelperService);

        $client->request('GET', self::URI);

        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $content = $response->getContent();
        $this->assertJson($content);
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('php', $responseData);
        $this->assertArrayHasKey('os', $responseData);
        $this->assertArrayHasKey('sf', $responseData);
        $this->assertArrayHasKey('db', $responseData);
    }
}
