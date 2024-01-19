<?php

namespace App\Service;

abstract class Broker {
    public string $baseUrl;

    public abstract function request(string $endpoint, string $method, string $secretKey, string $publicKey, array $queryParams): array;
    public abstract function mapOrdersToPositions(): array;
    public abstract function mapPositionsToDatabase(): array;
    public function storePositionsToDatabase(array $positions): array
    {
        foreach($positions as $value) {
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

                if ($positionOrder['side'] === 1) {
                    $side = "OPENLONG";
                }
                if ($positionOrder['side'] === 2) {
                    $side = "CLOSESHORT";
                }
                if ($positionOrder['side'] === 3) {
                    $side = "OPENSHORT";
                }
                if ($positionOrder['side'] === 4) {
                    $side = "CLOSELONG";
                }
                // $side = $positionOrder['side'] === 1 ? 'BUY' : 'SELL';
                // 	order direction
                // 1: open long
                // 2: close short
                // 3: open short
                // 4: close long

                // $side = 

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
    }
}

?>