<?php


namespace App\Entity;

use Symfony\Component\HttpFoundation\Request;

class StoreFactory
{
    public function create(Request $request): Store
    {
        $store = new Store();
        $store->setHost($request->getHttpHost());

        return $store;
    }
}