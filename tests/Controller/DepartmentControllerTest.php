<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DepartmentControllerTest extends WebTestCase
{
    public function testDepartments()
    {
        $client = self::createClient();
        $client->request('GET', 'api/department');
        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent(), true);


       // self::assertNotNull($decodedResponse);
       // self::assertTrue(is_array($decodedResponse));
        //self::assertGreaterThan(0, count($decodedResponse));
    }
}