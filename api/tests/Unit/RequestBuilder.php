<?php

namespace Tests\Unit;

class RequestBuilder
{
    private string $ip;

    private string $browser;

    private string $device;

    private string $referer;

    public function __construct()
    {
        $this->ip = '192.0.2.146';
        $this->browser = 'Chrome';
        $this->device = 'PC';
        $this->referer = 'google.com';
    }

    public function build()
    {
        $fakeRequest = \Symfony\Component\HttpFoundation\Request::create('/api/hit', 'Post');
        $fakeRequest->headers->set('REMOTE_ADDR', $this->ip);
        $fakeRequest->headers->set('HOST', 'localhost:8080');

        return $fakeRequest;
    }
}