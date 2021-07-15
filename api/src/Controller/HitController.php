<?php

declare(strict_types=1);

namespace App\Controller;


use App\Creator\HitCreator;
use App\Creator\StoreCreator;
use App\Entity\Store;
use App\Repository\StoreRepository;
use App\Service\StoreHitCreator;
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
    private StoreHitCreator $storeHitCreator;

    private StoreCreator $storeCreator;

    private HitCreator $hitCreator;


    public function __construct(
        StoreHitCreator $creator,
        StoreCreator $storeCreator,
        HitCreator $hitCreator,
    )
    {
        $this->storeHitCreator = $creator;
        $this->storeCreator = $storeCreator;
        $this->hitCreator = $hitCreator;
    }

    /**
     * @return JsonResponse
     * @Route("/hit", name="hit_add", methods={"POST"})
     */
    public function addHit(Request $request): Response
    {
       $store = $this->getDoctrine()
            ->getRepository(Store::class)
            ->findOneBy(['host' => $request->getHttpHost()]);

        if (!$store) {
            $store = $this->storeCreator->create($request);
        }
        $hit = $this->hitCreator->create($request, $store);
        $this->storeHitCreator->save($store, $hit);

        return new Response(
            'Saved new hit with id: '. $hit->getId()
        );
    }
}
