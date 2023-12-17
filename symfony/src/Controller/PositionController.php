<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\BrokerApiKey;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PositionController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    #[Route('/api/sync_position', name: 'api_sync_position', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $apiKeyId = $data['apiKeyId'] ?? null;
        $brokerApiKey = $entityManager->getRepository(BrokerApiKey::class)->find($apiKeyId);

        if (!$brokerApiKey) {
            throw $this->createNotFoundException(
                'No product found for id '.$apiKeyId
            );
        }

        $broker = $brokerApiKey->getBroker();

        dump($broker->getName());
        dump($broker->getId());
        dump($brokerApiKey->getAccessKey());
        dump($brokerApiKey->getSecretKey());

        $apiKey = "***REMOVED***";
        $apiSecret = "***REMOVED***";
        $timestamp = (string)round(microtime(true) * 1000);  // Génère le timestamp actuel
        $method = "GET";  // Méthode de la requête HTTP (GET, POST, etc.)

        $objectString = $apiKey . $timestamp;

        // Traitement différent selon la méthode de requête
        if ($method === 'POST') {
            // Pour POST, ajoutez le corps de la requête brute au string
            //$objectString .= file_get_contents('php://input');
        } else {
            // Pour GET, concaténez les paramètres de requête
            $queryParams = "page_num=1&page_size=10";  // Récupérer les paramètres de la requête GET
            //$queryString = http_build_query($queryParams);
            $objectString .= $queryParams;
        }

        // Utilisation de hash_hmac pour générer la signature
        $signature = hash_hmac('sha256', $objectString, $apiSecret);

        // Affichage des informations (à des fins de débogage ou de log)
        dump("Request-Time: {$timestamp})");
        dump("ApiKey: {$apiKey}");
        dump("Content-Type: application/json");
        dump("ObjectString: {$objectString}");
        dump("Signature: {$signature}");

        $this->client = $this->client->withOptions([
            'headers' => ['Request-Time' => $timestamp, 'ApiKey' => $apiKey, 'Content-Type' => 'application/json', 'Signature' => $signature],
        ]);

        $response = $this->client->request(
            'GET',
            'https://contract.mexc.com/api/v1/private/position/list/history_positions?page_num=1&page_size=10'
        );

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        dump($content);

        return $this->json([], $status = 200, $headers = [], $context = []);
    }


    private function fetchBrokerApi() {
        

        // Ajouter les headers requis pour une requête HTTP.
        // Dans un contexte PHP, vous devrez le faire avec curl ou un client HTTP, selon la façon dont vous faites la requête.

        /*
        Exemple avec curl:

        $headers = [
            'Request-Time: ' . $timestamp,
            'ApiKey: ' . $apiKey,
            'Content-Type: application/json',
            'Signature: ' . $signature
        ];

        // ... initialisation de curl et configuration des options ...
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        */
    }
}
