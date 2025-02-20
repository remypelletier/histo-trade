'use client';

import React, { useRef, useEffect } from 'react';
import { createChart } from 'lightweight-charts';
import moment from 'moment';

const MyChart = ({ kLines, position }: any) => {
  const chartContainerRef = useRef('chartId');

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
      crosshair: {
        mode: 0
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

    const candleSeries = chart.addCandlestickSeries({
      priceLineVisible: false,
      priceFormat: {
        type: 'price',
        precision: 3,
        minMove: 0.001
      }
    });
    candleSeries.setData(kLines);

    const markers = position.orders.map((order: any) => {
      const position = order.side === 'OPENLONG' || order.side === 'CLOSESHORT' ? 'belowBar' : 'aboveBar';
      const color = order.side === 'OPENLONG' || order.side === 'CLOSESHORT' ? '#00a400' : '#DC143C';
      const shape = order.side === 'OPENLONG' || order.side === 'CLOSESHORT' ? 'arrowUp' : 'arrowDown';
      const text = `${order.side === 'OPENLONG' || order.side === 'OPENSHORT' ? 'Open' : 'Close'} @${order.quantity} - ${order.open}`;

      return {
        time: order.createdTimestamp / 1000,
        position: position,
        color: color,
        shape: shape,
        text: text
      };
    });

    markers.sort((markerA, markerB) => {
      return markerA.time - markerB.time;
    });
    candleSeries.setMarkers(markers);

    const sellPriceLine = {
      price: position.closeAverage,
      color: '#DC143C',
      lineWidth: 1,
      lineStyle: 1, // LineStyle.Dashed
      axisLabelVisible: true,
      title: 'Avg close'
    };
    const buyPriceLine = {
      price: position.openAverage,
      color: '#00a400',
      lineWidth: 1,
      lineStyle: 1, // LineStyle.Dashed
      axisLabelVisible: true,
      title: 'Avg open'
    };

    candleSeries.createPriceLine(sellPriceLine);
    candleSeries.createPriceLine(buyPriceLine);

    chart.timeScale().fitContent();

    return () => chart.remove();
  }, [kLines]);

  return <div ref={chartContainerRef} style={{ width: '100%', height: '100%' }} />;
};

export default MyChart;
