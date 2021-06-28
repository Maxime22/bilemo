<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ArrayObject;

class OpenApiFactory implements OpenApiFactoryInterface
{

    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        // getPaths returns what is in path attribute

        // TODO, delete this foreach if i don't need it at the end
        foreach ($openApi->getPaths()->getPaths() as $key => $path) {
            // getGet returns what is in get attribute in path attribute
            // getSummary returns the value of the summary of get here
            // key is something like /api/products/{id}
            // to not display the GET where the attribute summary is equal to "hidden"s
            if ($path->getGet() && $path->getGet()->getSummary() === "hidden") {
                // addPath modify (or create) the path where the key is $key and withGet modify the get to null
                $openApi->getPaths()->addPath($key, $path->withGet(null));
            }
        }

        // if i want to create a path
        // $openApi->getPaths()->addPath('/ping', new PathItem(null, 'Ping', null, new Operation('ping-id', [], [], "Répond")));

        $schemas = $openApi->getComponents()->getSecuritySchemes();
        // add authorize bearer in OpenApi to test authorization in the doc directly (we need to add "security"={{"bearerAuth"={}}} in the IRI concerned)
        $schemas['bearerAuth'] = new \ArrayObject([
            'type' => 'http',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT'
        ]);

        $schemas['Credentials'] = new \ArrayObject(
            [
                "type" => "object",
                "properties" => [
                    'username' => [
                        'type' => 'string',
                        'example' => 'Phone Enterprise'
                    ],
                    'password' => [
                        'type' => 'string',
                        'example' => '1234Jean%1234'
                    ]

                ]
            ]
        );

        $schemas['Token'] = new \ArrayObject(
            [
                "type" => "object",
                "properties" => [
                    'token' => [
                        'type' => 'string',
                        'readOnly' => true
                    ]
                ]
            ]
        );

        $contentRequestBodyOperationToken = new ArrayObject([
            'application/json' => [
                'schema' => $schemas['Credentials']
            ]
        ]);
        $requestBodyOperationToken = new RequestBody('', $contentRequestBodyOperationToken);

        $operationToken = new Operation(
            "postApiLogin",
            ['Auth'],
            [
                '200' => [
                    'description' => 'Token JWT',
                    'content' => [
                        'application/json' => [
                            'schema' => $schemas['Token']
                        ]
                    ]
                ]
            ],
            '',
            '',
            null,
            [],
            $requestBodyOperationToken
        );

        $pathItemLogin = new PathItem(null, null, null, null, null, $operationToken);

        $openApi->getPaths()->addPath('/api/login', $pathItemLogin);

        return $openApi;
    }
}
