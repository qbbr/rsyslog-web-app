<?php

declare(strict_types=1);

namespace App\Controller;

use App\Config;
use App\Pagination\PaginationDataCollector;
use App\Repository\SystemEventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class DefaultController extends AbstractController
{
    public function __construct(
        private readonly SystemEventsRepository $systemEventsRepository,
        private readonly PaginationDataCollector $paginationDataCollector,
    ) {
    }

    #[Route('/latest')]
    public function latest(
        Request $request,
    ): JsonResponse {
        $page = $request->query->getInt('page', 1);
        $pageSize = $request->query->getInt('pageSize', Config::PAGE_SIZE);
        $searchQuery = $request->query->get('searchQuery');

        $paginator = $this->systemEventsRepository->findLatest($page, $pageSize, $searchQuery);
        $data = $this->paginationDataCollector->getData($paginator);

        return new JsonResponse($data);
    }
}
