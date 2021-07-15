<?php

namespace App\Service;


use App\Entity\Hit;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;

class StoreHitCreator
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Store $store, Hit $hit)
    {
        $this->em->persist($hit);
        $this->em->persist($store);

        $this->em->flush();
    }
}