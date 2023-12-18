<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\BrokerApiKey;
use App\Entity\Position;
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
        $user = $brokerApiKey->getUser();

        dump($broker->getName());
        dump($broker->getId());
        dump($brokerApiKey->getAccessKey());
        dump($brokerApiKey->getSecretKey());

        $apiKey = $brokerApiKey->getAccessKey();
        $apiSecret = $brokerApiKey->getSecretKey();
        $timestamp = (string)round(microtime(true) * 1000);  // current
        $method = "GET";

        $objectString = $apiKey . $timestamp;
        $url = "https://contract.mexc.com/api/v1/private/position/list/history_positions";
        $queryParams = ['page_num' => '1', 'page_size' => '10'];
        $queryString = http_build_query($queryParams);
        $url = $url . "?" . $queryString;
        $objectString .= $queryString;

        $signature = hash_hmac('sha256', $objectString, $apiSecret);

        $this->client = $this->client->withOptions([
            'headers' => ['Request-Time' => $timestamp, 'ApiKey' => $apiKey, 'Content-Type' => 'application/json', 'Signature' => $signature],
        ]);

        $response = $this->client->request(
            'GET',
            'https://contract.mexc.com/api/v1/private/position/list/history_positions?page_num=1&page_size=10'
        );

        $statusCode = $response->getStatusCode();
        $content = $response->toArray();

        $user = $brokerApiKey->getUser();
        $res = array_map(function($position) use ($user, $broker) {
            $positionType = $position['positionType'] === 1 ? 'BUY' : 'SELL';
            return [
                'brokerPositionId' => $position['positionId'],
                'symbol' => $position['symbol'],
                'open_average' => $position['openAvgPrice'],
                'close_average' => $position['closeAvgPrice'],
                'side' => $positionType,
                'pnl' => $position['realised'],
                'quantity' => $position['closeVol'],
                'leverage' => $position['leverage'],
                'created_timestamp' => $position['createTime'],
                'ended_timestamp' => $position['updateTime'],
                'fee' => $position['fee'],
                'user_id' => $user->getId(),
                'broker_id' => $broker->getId()
            ];
        }, $content['data']);

        dump($res);

        foreach($res as $value) {
            $position = new Position();
            
            $position->setBrokerPositionId($value['brokerPositionId']);
            $position->setSymbol($value['symbol']);
            $position->setOpenAverage(($value['open_average']));
            $position->setCloseAverage($value['close_average']);
            $position->setSide($value['side']);
            $position->setPnl($value['pnl']);
            $position->setQuantity($value['quantity']);
            $position->setLeverage($value['leverage']);
            $position->setCreatedTimestamp($value['created_timestamp']);
            $position->setEndedTimestamp($value['ended_timestamp']);
            $position->setFee($value['fee']);
            $position->setUser($user);
            $position->setBroker($broker);

            dump($position);
            $entityManager->persist($position);
        }
        

    $entityManager->flush();

        return $this->json([], $status = 200, $headers = [], $context = []);
    }

}
