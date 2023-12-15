import React from 'react';
import { createChart } from 'lightweight-charts';
import MyChart from '@/components/MyChart';
import { promises as fs } from 'fs';
import MyTrades from '@/components/MyTrades';

export default async function page() {
  const file = await fs.readFile(process.cwd() + '/data/btcusdt15min.json', 'utf8');
  const data = JSON.parse(file);
  // const endpoint =
  //   "https://api.mexc.com/api/v3/klines?symbol=ETHUSDT&interval=15m";
  // const file = await fetch(endpoint);
  // const data = await file.json();
  const kLines = data.map((elem: any) => {
    return {
      time: elem[0],
      open: parseFloat(elem[1]),
      high: parseFloat(elem[2]),
      low: parseFloat(elem[3]),
      close: parseFloat(elem[4])
    };
  });

  return (
    <div className="flex">
      {/* Chart */}
      <div className="w-9/12 bg-slate-400 h-screen">
        <MyChart kLines={kLines} />
      </div>
      {/* List trade */}
      <div className="w-3/12 bg-slate-300 dark:bg-gray-800">
        <MyTrades />
      </div>
    </div>
  );
}
