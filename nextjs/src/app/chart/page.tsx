'use client';

import React, { useEffect, useState } from 'react';
import MyChart from '@/components/MyChart';
import MyTrades from '@/components/MyTrades';
import { api } from '@/config';
import Filter from '@/components/Filter';

export default function page() {
  const [selectedPosition, setSelectedPosition] = useState(0);
  const [positions, setPositions] = useState(null);
  const [kLines, setKLines] = useState(null);

  useEffect(() => {
    if (!positions) {
      fetch(`${api.baseUrl}/api/users/1/positions?page=1`)
        .then(res => res.json())
        .then(res => {
          setPositions(res);
        });
    }
    if (positions) {
      const position = positions['hydra:member'][selectedPosition];
      console.log(positions);
      const symbol = position.symbol;
      const endpoint = `https://contract.mexc.com/api/v1/contract/kline/${symbol}?interval=Min1&start=${position.createdTimestamp / 1000 - 16000}&end=${
        position.endedTimestamp / 1000 + 16000
      }`;
      const endpointEncoded = encodeURIComponent(endpoint);
      fetch(`/api?url=${endpointEncoded}`)
        .then(res => {
          return res.json();
        })
        .then(res => {
          const data = res['data'];
          setKLines(
            data['time'].map((elem: any, index: any) => {
              return {
                time: data['time'][index],
                open: data['open'][index],
                high: data['high'][index],
                low: data['low'][index],
                close: data['close'][index]
              };
            })
          );
        });
    }
  }, [selectedPosition, positions]);

  const handleClick = res => {
    console.log(res);
    setSelectedPosition(res);
  };

  if (!positions) return <p>Loading</p>;
  if (!kLines) return <p>Loading</p>;

  return (
    <div>
      <Filter></Filter>
      <div className="flex">
        <div className="max-w-9/12 w-9/12 bg-slate-400 h-screen">
          <MyChart kLines={kLines} position={positions['hydra:member'][selectedPosition]} />
        </div>
        <div className="w-3/12 bg-slate-300 dark:bg-gray-800">
          <MyTrades positions={positions} onClick={handleClick} selectedIndex={selectedPosition} />
        </div>
        {/* <FetchComponent position={positions['hydra:member'][selectedPosition]} /> */}
      </div>
    </div>
  );
}
