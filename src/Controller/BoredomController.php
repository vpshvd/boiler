<?php

namespace App\Controller;

use App\Services\ActivityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/api')]
class BoredomController extends AbstractController
{
    public function __construct(protected ActivityServiceInterface $activityService)
    {
    }

    #[Route('/participants/{participants}', name: 'activity')]
    public function index(int $participants): JsonResponse
    {

        return $this->activityService->getData($participants);
    }
}