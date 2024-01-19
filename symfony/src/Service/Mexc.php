<?php 

namespace App\Service;

use App\Service\Broker;

class Mexc extends Broker {
    public function request(string $endpoint, string $method, string $secretKey, string $publicKey, array $queryParams): array {
        return [];
    }
    public function mapOrdersToPositions(): array {
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

        return $res;
    }
    public function mapPositionsToDatabase(): array {
        

        return [];
    }
}

?>