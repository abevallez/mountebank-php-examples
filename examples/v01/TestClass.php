<?php

namespace MountebankPHPExamples\v01;

use GuzzleHttp\Client;
use MountebankPHP\Application\ServiceVirtualization;
use MountebankPHP\Domain\Imposter;
use MountebankPHP\Domain\Predicate;
use MountebankPHP\Domain\Response;
use MountebankPHP\Domain\Stub;
use MountebankPHP\Infrastructure\Http\HttpClient;

/**
 * Class TestClass
 */
class TestClass
{
    /**
     * Run tests
     */
    public function run()
    {
        $responseJson = [
            'is' => ['statusCode' => 400]
        ];

        $predicateJson = [
            'equals'=> [
                'path' => '/test',
                'method' => 'POST',
            ]
        ];

        $predicate = new Predicate();
        $predicate->setJsonDefinition($predicateJson);

        $response = new Response();
        $response->setJsonDefinition($responseJson);

        $stub = new Stub();
        $stub->addPredicate($predicate);
        $stub->addResponse($response);

        $imposter = new Imposter();
        $imposter->setPort(4545);
        $imposter->setProtocol(Imposter::HTTP_PROTOCOL);
        $imposter->addStub($stub);

        $httpClient = new HttpClient();
        $mountebankPhp = new ServiceVirtualization($httpClient);

        $mountebankPhp->setServiceHost('http://127.0.0.1:2525');
        $mountebankPhp->setImposterInService($imposter);
    }
}