<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends ApiTestCase
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
    public function testGetProductsWithoutAuthentication()
    {
        $this->client->request('GET', '/api/products');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetProductsWithAuthentication()
    {
        $this->client->request(
            'GET',
            '/api/products',
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

    public function testGetOneProductWithAuthentication()
    {
        $this->client->request(
            'GET',
            '/api/products/1',
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

    // TODO ALLER UN PEU PLUS LOIN QUE HTTP RESPONSE OK EN EXPLIQUANT CE QU'ON ATTEND DE LA REPONSE
}
