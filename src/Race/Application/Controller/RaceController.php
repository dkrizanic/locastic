<?php

namespace App\Race\Application\Controller;

use App\Race\Domain\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class RaceController extends AbstractController
{
    public function __construct(
        private RaceRepository $raceRepository
    ) {
    }

    public function getRaces(): JsonResponse
    {
        return new JsonResponse($this->raceRepository->fetchAll());
    }
}
