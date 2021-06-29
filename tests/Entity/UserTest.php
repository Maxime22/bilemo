<?php

namespace App\Tests\Entity;

use App\Entity\User;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends ApiTestCase
{
    public function setUp(): void
    {
        $this->client = static::createClient();

        $response = $this->client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'username' => 'Phone Enterprise',
                'password' => '1234Jean%1234',
            ],
        ]);

        $json = $response->toArray();
        $this->token = $json['token'];
    }

    public function testGetUsersWithoutAuthentication()
    {
        $this->client->request('GET', '/api/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    /* public function testGetUsersWithAuthentication()
    {
        // TODO
    }

    public function testGetUsersWithAuthenticationButWrongUser()
    {
        // TODO
    } */
}