<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel;
use App\Service\Helper\DbHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class InfoController extends AbstractController
{
    public function __construct(
        private readonly DbHelper $dbHelper,
        private readonly ParameterBagInterface $parameterBag,
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
                'env' => $this->parameterBag->get('kernel.environment'),
            ],
            'db' => [
                'ver' => $this->dbHelper->getVersion(),
                'size' => $this->dbHelper->getSize(),
            ],
        ]);
    }
}
