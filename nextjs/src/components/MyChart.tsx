'use client';

import React, { useRef, useEffect } from 'react';
import { createChart } from 'lightweight-charts';

const MyChart = ({ kLines }: any) => {
  const chartContainerRef = useRef('chartId');

  useEffect(() => {
    const chart = createChart(chartContainerRef.current, {
      layout: {
        background: '#131722', // Arrière-plan foncé
        textColor: '#d1d4dc' // Couleur du texte
      },
      grid: {
        vertLines: {
          color: 'rgba(42, 46, 57, 0.6)' // Lignes verticales
        },
        horzLines: {
          color: 'rgba(42, 46, 57, 0.6)' // Lignes horizontales
        }
      }
    });
    var candleSeries = chart.addCandlestickSeries({});
    candleSeries.setData(kLines);
    return () => chart.remove();
  }, []);

  return <div ref={chartContainerRef} style={{ width: '100%', height: '100%' }} />;
};

export default MyChart;
