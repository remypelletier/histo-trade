'use client';

import React, { useRef, useEffect } from 'react';
import { createChart } from 'lightweight-charts';
import moment from 'moment';

const MyChart = ({ kLines, position }: any) => {
  const chartContainerRef = useRef('chartId');

  console.log(position);

  useEffect(() => {
    const chart = createChart(chartContainerRef.current, {
      layout: {
        background: '#131722', // Arrière-plan foncé
        textColor: '#d1d4dc' // Couleur du texte
      },
      timeScale: {
        timeVisible: true,
        secondsVisible: false // Les secondes ne sont pas nécessaires pour une granularité à la minute
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

    const candleSeries = chart.addCandlestickSeries({});
    candleSeries.setData(kLines);

    const markers = [
      {
        time: position.createdTimestamp / 1000,
        position: 'belowBar',
        color: '#00a400',
        shape: 'arrowUp',
        text: 'Buy'
      },
      {
        time: position.endedTimestamp / 1000,
        position: 'aboveBar',
        color: '#DC143C',
        shape: 'arrowDown',
        text: 'Sell'
      }
    ];

    candleSeries.setMarkers(markers);

    const sellPriceLine = {
      price: position.closeAverage,
      color: '#3179F5',
      lineWidth: 1,
      lineStyle: 1, // LineStyle.Dashed
      axisLabelVisible: true,
      title: 'Avg sell'
    };
    const buyPriceLine = {
      price: position.openAverage,
      color: '#3179F5',
      lineWidth: 1,
      lineStyle: 1, // LineStyle.Dashed
      axisLabelVisible: true,
      title: 'Avg buy'
    };

    candleSeries.createPriceLine(sellPriceLine);
    candleSeries.createPriceLine(buyPriceLine);

    chart.timeScale().fitContent();

    return () => chart.remove();
  }, []);

  return <div ref={chartContainerRef} style={{ width: '100%', height: '100%' }} />;
};

export default MyChart;
