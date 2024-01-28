<?php

namespace App\Controller;


use App\Entity\Division;
use App\Entity\Tournament;
use App\Service\ScheduleGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/create_schedule/{id}', name: 'create_schedule', methods: ['POST'])]
    public function createSchedule(
        Tournament $tournament,
        ScheduleGenerator $scheduleGenerator
    ): JsonResponse
    {
        $scheduleGenerator->generateSchedule($tournament);

        return $this->json([
            'success' => true
        ]);
    }
}
