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
use App\Entity\Order;

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

        $positionContent = $this->mexcRequest('GET', $apiKey, 'https://contract.mexc.com/api/v1/private/position/list/history_positions', ['page_num' => '1', 'page_size' => '10'], $apiSecret);
        $orderContent = $this->mexcRequest('GET', $apiKey, 'https://contract.mexc.com/api/v1/private/order/list/history_orders', ['page_num' => '1', 'page_size' => '100', 'state' => 3], $apiSecret);
        
        dump($orderContent); // api/v1/private/order/list/history_orders

        $user = $brokerApiKey->getUser();
        $res = array_map(function($position) use ($user, $broker, $orderContent) {
            $positionType = $position['positionType'] === 1 ? 'BUY' : 'SELL';

            $orders = array_filter($orderContent['data'], function($order) use ($position) {
               return $order['positionId'] === $position['positionId'] && $order['state'] === 3;
            });

            $currentVolume = 0;
            $resArray = [];
            foreach ($orderContent['data'] as $key => $order) {
                if ($currentVolume >= $position['closeVol']) {
                    break;
                }
                if ($order['symbol'] === $position['symbol'] && $order['state'] === 3) {
                    if ($positionType === 'BUY') {
                        if ($order['side'] === 1) {
                            array_push($resArray, $order);
                            $currentVolume += $order['vol'];
                            unset($orderContent['data'][$key]);
                        }
                    }
                    if ($positionType === 'SELL') {
                        if ($order['side'] === 3) {
                            array_push($resArray, $order);
                            $currentVolume += $order['vol'];
                            unset($orderContent['data'][$key]);                            
                        }
                    }
                }
            }

            $orders = array_merge($orders, $resArray);

            // dump($orders);
            // 1 open long 3 open close

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
                'orders' => $orders,
                'user_id' => $user->getId(),
                'broker_id' => $broker->getId()
            ];
        }, $positionContent['data']);

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

            dump($value);

            foreach ($value['orders'] as $positionOrder) {
                $order = new Order();

                $side = $positionOrder['side'] === 1 ? 'BUY' : 'SELL';

                $feeType = 'MAKER';
                if ($positionOrder['orderType'] > 2) {
                    $feeType = 'TAKER';
                }

                $order->setBrokerOrderId($positionOrder['orderId']);
                $order->setOpen($positionOrder['price']);
                $order->setFee($positionOrder['makerFee'] + $positionOrder['takerFee']);
                $order->setFeeType($feeType);
                $order->setSide($side);
                $order->setQuantity($positionOrder['vol']);
                $order->setLeverage($positionOrder['leverage']);
                $order->setCreatedTimestamp($positionOrder['updateTime']);
                $order->setPosition($position);

                $entityManager->persist($order);

                $position->addOrder($order);
            }

            // dump($position);
            $entityManager->persist($position);
        }
        
    $entityManager->flush();

        return $this->json([], $status = 200, $headers = [], $context = []);
    }

    private function mexcRequest($method, $apiKey, $url, $queryParams, $apiSecret) {
        $timestamp = (string)round(microtime(true) * 1000);  // current

        //$method = "GET";
        $objectString = $apiKey . $timestamp;
        //$url = "https://contract.mexc.com/api/v1/private/position/list/history_positions";
        //$queryParams = ['page_num' => '1', 'page_size' => '10'];
        $queryString = http_build_query($queryParams);
        $url = $url . "?" . $queryString;
        $objectString .= $queryString;

        $signature = hash_hmac('sha256', $objectString, $apiSecret);

        $this->client = $this->client->withOptions([
            'headers' => ['Request-Time' => $timestamp, 'ApiKey' => $apiKey, 'Content-Type' => 'application/json', 'Signature' => $signature],
        ]);

        $response = $this->client->request(
            $method,
            $url
        );

        //$statusCode = $response->getStatusCode();
        $content = $response->toArray();

        return $content;

    }


// 'https://contract.mexc.com/api/v1/private/position/list/history_positions?page_num=1&page_size=10'
//         $queryParams = ['page_num' => '1', 'page_size' => '10'];

}
