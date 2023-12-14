"use client";

import React, { useRef, useEffect } from "react";
import { createChart } from "lightweight-charts";

const MyChart = ({ kLines }: any) => {
  const chartContainerRef = useRef("chartId");

  useEffect(() => {
    const chart = createChart(chartContainerRef.current, {});
    var candleSeries = chart.addCandlestickSeries({});
    candleSeries.setData(kLines);
    return () => chart.remove();
  }, []);

  return (
    <div ref={chartContainerRef} style={{ width: "100%", height: "100%" }} />
  );
};

export default MyChart;
