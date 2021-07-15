<?php


namespace App\Creator;


use App\Entity\Hit;
use App\Entity\Store;
use DateTime;
use DeviceDetector\DeviceDetector;
use Symfony\Component\HttpFoundation\Request;

class HitCreator
{
    private const PC = 'PC';

    public function create(Request $request, Store $store): Hit
    {
        $deviceDetected = self::deviceDetected($request);
        $device = $deviceDetected->getDevice();
        if (!$device) {
            $device = self::PC;
        }

        $hit = new Hit();
        $hit->setIp($request->getClientIp());
        $hit->setBrowser($deviceDetected->getClient('name'));
        $hit->setDevice($device);
        $hit->setReferer($request->headers->get('referer'));
        $hit->setCreatedAt(\DateTimeImmutable::createFromMutable(new DateTime()));

        $hit->setStore($store);

        return $hit;
    }

    private static function deviceDetected(Request $request): DeviceDetector
    {
        $dd = new DeviceDetector($request->headers->get('User-Agent'));
        $dd->parse();

        return $dd;
    }
}