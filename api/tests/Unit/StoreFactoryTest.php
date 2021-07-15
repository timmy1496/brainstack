<?php


namespace Tests\Unit;


use App\Entity\Store;
use App\Entity\StoreFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class StoreFactoryTest extends TestCase
{
    private StoreFactory $storeFactory;

    private $fakeRequest;

    public function setUp(): void
    {
        $this->fakeRequest = Request::create('/api/hit', 'Post');
        $this->fakeRequest->headers->set('HOST', 'localhost:8080');
        $this->storeFactory = new StoreFactory();
    }

    public function testSuccess()
    {
        $storeFactory = $this->storeFactory->create($this->fakeRequest);

        self::assertEquals('localhost:8080', $storeFactory->getHost());
    }

    public function testFailed()
    {
        $storeFactory = $this->storeFactory->create($this->fakeRequest);

        self::assertNotEquals('localhost:8081', $storeFactory->getHost());
    }

    public function testEmptyStore()
    {
        $this->expectException(\TypeError::class);

        $storeFactory = $this->storeFactory->create(null);
    }
}