<?php


namespace App\Creator;

use App\Entity\Store;
use Symfony\Component\HttpFoundation\Request;

class StoreCreator
{
    public function create(Request $request): Store
    {
        $store = new Store();
        $store->setHost($request->getHttpHost());

        return $store;
    }
}