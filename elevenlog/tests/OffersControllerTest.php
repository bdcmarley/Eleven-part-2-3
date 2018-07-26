<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use src\Controller\OffersController;
// use Acme\Bundle\ApiBundle\Tests\WebTestCase;

class OffersControllerTest extends TestCase
{
    public function testIndex()
    {
      // $client = $this->createAuthenticatedClient('http://localhost:8000/offers/', 'api')
      $this->execQuery('', 'GET', null, 'createAuthenticatedClient');
      $response = $client->getResponse();
      $this->assertJsonResponse($response, 200);

      $content = json_decode($response->getContent(), true);
      $this->assertInternalType('array', $content);
      $this->assertCount(3, $content);

      $comment = $content[0];
      $this->assertArrayHasKey('body', $comment);
      $this->assertArrayHasKey('status', $comment);
      $this->assertArrayNotHasKey('content', $comment);
      $this->assertArrayNotHasKey('password', $comment['user']);

    }
}
