<?php


namespace App\Entity;


use App\Entity;

use DateTime;
use DeviceDetector\DeviceDetector;
use Symfony\Component\HttpFoundation\Request;

class HitFactory
{
    public function create(Request $request, Store $store): Hit
    {
        $deviceDetected = self::deviceDetected($request);

        $hit = new Hit();
        $hit->setIp($request->getClientIp());
        $hit->setBrowser($deviceDetected->getClient('name'));
        $hit->setDevice($deviceDetected->getDevice() !== 0 ? $deviceDetected->getDevice() : 'PC');
        $hit->setReferer($request->headers->get('referer'));
        $hit->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()));

        $hit->setStore($store);

        return $hit;
    }

    private static function deviceDetected(Request $request)
    {
        $dd = new DeviceDetector($request->headers->get('User-Agent'));
        $dd->parse();

        return $dd;
    }
}