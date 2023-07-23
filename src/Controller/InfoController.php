<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel;
use App\Service\Helper\DbHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class InfoController extends AbstractController
{
    public function __construct(
        private readonly DbHelper $dbHelper,
    ) {
    }

    #[Route('/info')]
    public function info(): JsonResponse
    {
        return new JsonResponse([
            'php' => [
                'ver' => \PHP_VERSION,
            ],
            'os' => \PHP_OS,
            'sf' => [
                'ver' => Kernel::VERSION,
            ],
            'db' => [
                'ver' => $this->dbHelper->getVersion(),
            ],
        ]);
    }
}
