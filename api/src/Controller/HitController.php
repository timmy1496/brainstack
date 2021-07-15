<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Hit;
use App\Entity\HitFactory;
use App\Entity\Store;
use App\Entity\StoreFactory;
use App\Service\StoreHitCreator;
use DateTime;
use DeviceDetector\DeviceDetector;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\IpUtils;

/**
 * Class HitController
 * @package App\HitController
 * @Route("/api", name="hit_api", methods={"POST"})
 */
class HitController extends AbstractController
{

    private StoreHitCreator $storeHitCreator;

    private StoreFactory $storeFactory;

    private HitFactory $hitFactory;


    public function __construct(StoreHitCreator $creator, StoreFactory $storeFactory, HitFactory $hitFactory)
    {
        $this->storeHitCreator = $creator;
        $this->storeFactory = $storeFactory;
        $this->hitFactory = $hitFactory;
    }

    /**
     * @return JsonResponse
     * @Route("/hit", name="hit_add", methods={"GET"})
     */
    public function addHit(Request $request): Response
    {
        $store = $this->getDoctrine()
            ->getRepository(Store::class)
            ->findOneBy(['host' => $request->getHttpHost()]);

        if (!$store) {
            $store = $this->storeFactory->create($request);
        }
        $hit = $this->hitFactory->create($request, $store);
        $this->storeHitCreator->save($store, $hit);

        return new Response(
            'Saved new hit with id: '. $hit->getId()
        );
    }
}
