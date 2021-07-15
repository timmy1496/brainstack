<?php

namespace Tests\Unit;

use App\Entity\HitFactory;
use App\Entity\Store;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;


class HitFactoryTest extends TestCase
{
    private $fakeRequest;

    private $store;

    private const USER_AGENT = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36';

    public function setUp(): void
    {
       $this->fakeRequest = Request::create('/api/hit', 'Post');
       $this->fakeRequest->headers->set('REMOTE_ADDR', '192.0.2.146');
       $this->fakeRequest->headers->set('HOST', 'localhost:8080');
       $this->fakeRequest->headers->set('REFERER', 'google.com');
       $this->fakeRequest->headers->set('USER-AGENT', self::USER_AGENT);
       $this->store = new Store();
       $this->store->setHost('192.0.2.146');
    }

    public function testSuccess()
    {
        $hitFactory = (new HitFactory())->create($this->fakeRequest, $this->store);

        self::assertEquals('127.0.0.1', $hitFactory->getIp());
        self::assertEquals('Chrome', $hitFactory->getBrowser());
        self::assertEquals('PC', $hitFactory->getDevice());
        self::assertEquals('google.com', $hitFactory->getReferer());

    }

    public function testEmptyRequest()
    {
        $this->expectException(\TypeError::class);
        $hitFactory = (new HitFactory())->create(null, $this->store);
    }

    public function testEmptyStore()
    {
        $this->expectException(\TypeError::class);
        $hitFactory = (new HitFactory())->create($this->fakeRequest, null);
    }

    public function testFailed()
    {
        $hitFactory = (new HitFactory())->create($this->fakeRequest, $this->store);

        self::assertNotEquals('127.0.0.2', $hitFactory->getIp());
        self::assertNotEquals('Opera', $hitFactory->getBrowser());
        self::assertNotEquals('mobile', $hitFactory->getDevice());
        self::assertNotEquals('facebook', $hitFactory->getReferer());
    }
}