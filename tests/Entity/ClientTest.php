<?php

namespace App\Tests\Entity;

use App\Entity\Client;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class ClientTest extends ApiTestCase
{
    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testLogin(){
        // retrieve a token
        $response = $this->client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'username' => 'Phone Enterprise',
                'password' => '1234Jean%1234',
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);
    }

    public function testLoginBadCredentials(){
        $this->client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'username' => 'Phone Enterprise',
                'password' => '1234Jean%123',
            ],
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

}