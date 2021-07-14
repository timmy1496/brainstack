<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HitController
 * @package App\HitController
 * @Route("/api", name="hit_api", methods={"POST"})
 */
class HitController extends AbstractController
{
    /**
     * @return JsonResponse
     * @Route("/hit", name="hit_add", methods={"GET"})
     */
    public function addHit(Request $request): Response
    {
//        dd($request->getHttpHost());
//        dd($_SERVER['HTTP_HOST']);
//        dd($request->headers->get('referer'));
//        dd($request->headers->get('User-Agent'));
//        dd($ip = $request->getClientIp());

        return $this->json([
            'message' => 'add hit!',
            'path' => 'src/Controller/HitController.php',
        ]);
    }
}
