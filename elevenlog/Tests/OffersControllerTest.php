<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use src\Controller\OffersController;
// use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use Guzzle\Http\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
require_once 'vendor/autoload.php';


class OffersControllerTest extends TestCase
{
    public function testPOST()
    {

        // Ici, on simule un client.
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
            'debug' => true,
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        // On prepare des donnees a envoyer au POST
        $donnees_offer = array(
            'title' => 'TestOne',
            'content' => 'Voici un tres beau contenus',
            'description' => 'Je decris la ca se voit',
            'price' => 555
        );

        // On envoie notre requete.
        $response = $client->post('/offers/new', [
            'body' => json_encode($donnees_offer)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
    }
}
?>
