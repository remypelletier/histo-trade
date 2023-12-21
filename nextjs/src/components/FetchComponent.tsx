'use client';

import React, { useEffect } from 'react';

export default function FetchComponent({ position }: any) {
  useEffect(() => {
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
        console.log(res);
      });
  }, []);
  return <div>FetchComponent</div>;
}
