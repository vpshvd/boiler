<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ActivityServiceInterface
{
    public function getData(int $participants): JsonResponse;
}