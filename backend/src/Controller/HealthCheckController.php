<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HealthCheckController extends AbstractController
{
    #[Route('/api/ping', name: 'api_ping', methods: ['GET'])]
    public function ping(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
