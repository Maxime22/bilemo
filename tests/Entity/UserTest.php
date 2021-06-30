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

    // GET USERS
    public function testGetUsersWithoutAuthentication()
    {
        $this->client->request('GET', '/api/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetUsersWithAuthentication()
    {
        $this->client->request(
            'GET',
            '/api/users',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json'
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    // GET USER
    public function testGetOneUserWithoutAuthentication()
    {
        $this->client->request('GET', '/api/users/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetOneUserWithAuthentication()
    {
        $this->client->request(
            'GET',
            '/api/users/1',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json'
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetOneUserWithAuthenticationButWrongClient()
    {
        // the second user belongs to the other client
        $this->client->request(
            'GET',
            '/api/users/2',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json'
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    // POST
    public function testPostUserWithoutAuthentication()
    {
        $this->client->request('POST', '/api/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testPostUserWithAuthentication()
    {
        $this->client->request(
            'POST',
            '/api/users',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json'
                ],
                'json' => [
                    "mail" => "user@example.com",
                    "firstName" => "string",
                    "lastName" => "string"
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    // PUT
    public function testPutUserWithoutAuthentication()
    {
        $this->client->request('PUT', '/api/users/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testPutUserWithAuthentication()
    {
        $this->client->request(
            'PUT',
            '/api/users/1',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json'
                ],
                'json' => [
                    "mail" => "user2@example.com"
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testPutUserWithAuthenticationButWrongClient()
    {
        $this->client->request(
            'PUT',
            '/api/users/2',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json'
                ],
                'json' => [
                    "mail" => "user2@example.com"
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    // DELETE
    public function testDeleteUserWithoutAuthentication()
    {
        $this->client->request('DELETE', '/api/users/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testDeleteUserWithAuthentication()
    {
        $this->client->request(
            'DELETE',
            '/api/users/1',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json'
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function testDeleteUserWithAuthenticationButWrongClient()
    {
        $this->client->request(
            'DELETE',
            '/api/users/2',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json'
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
