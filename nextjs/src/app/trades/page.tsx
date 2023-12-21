import React from 'react';
import { createChart } from 'lightweight-charts';
import MyChart from '@/components/MyChart';
import { promises as fs } from 'fs';
import MyTrades from '@/components/MyTrades';
import { api } from '@/config';
import moment from 'moment';

export default async function page() {
  // fetch l'api pour afficher les positions de l'utilisateur connecté

  const positionsPromise = await fetch(`${api.baseUrl}/api/users/1/positions?page=1`);
  const positions = await positionsPromise.json();

  const selectedPosition = 3;

  // lorsqu'une position est sélectionné récupérer le temps pour définir l'intervale
  // rechercher les données sur l'api du broker
  // afficher les positions et les données sur le chart

  //  const file = await fs.readFile(process.cwd() + '/data/btcusdt15min.json', 'utf8');
  //const data = JSON.parse(file);
  const symbol = positions['hydra:member'][selectedPosition].symbol.replace('_', '');
  const endpoint = `https://api.mexc.com/api/v3/klines?symbol=${symbol}&interval=1m&startTime=${positions['hydra:member'][selectedPosition].createdTimestamp - 8000000}&endTime=${
    positions['hydra:member'][selectedPosition].endedTimestamp + 8000000
  }`;
  const file = await fetch(endpoint);
  const data = await file.json();

  const kLines = data.map((elem: any) => {
    return {
      time: elem[0] / 1000,
      open: parseFloat(elem[1]),
      high: parseFloat(elem[2]),
      low: parseFloat(elem[3]),
      close: parseFloat(elem[4])
    };
  });

  return (
    <div className="flex">
      <div className="max-w-9/12 w-9/12 bg-slate-400 h-screen">
        <MyChart kLines={kLines} position={positions['hydra:member'][selectedPosition]} />
      </div>
      <div className="w-3/12 bg-slate-300 dark:bg-gray-800">
        <MyTrades positions={positions} />
      </div>
    </div>
  );
}
