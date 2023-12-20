'use client';

import React from 'react';
import { Table } from 'flowbite-react';

export default function MyTrades({ positions }) {
  return (
    <Table className="w-full">
      <Table.Head>
        <Table.HeadCell>Symbol</Table.HeadCell>
        <Table.HeadCell>pnl</Table.HeadCell>
        <Table.HeadCell>Side</Table.HeadCell>
        <Table.HeadCell>Date</Table.HeadCell>
      </Table.Head>
      <Table.Body className="divide-y">
        {positions['hydra:member'].map(position => {
          return (
            <Table.Row key={position.id} className="bg-white dark:border-gray-700 dark:bg-gray-800 hover:bg-gray-700">
              <Table.Cell className="whitespace-nowrap font-medium text-gray-900 dark:text-white">{position.symbol}</Table.Cell>
              <Table.Cell>{position.pnl}</Table.Cell>
              <Table.Cell>{position.side}</Table.Cell>
              <Table.Cell>{position.endedTimestamp}</Table.Cell>
            </Table.Row>
          );
        })}
      </Table.Body>
    </Table>
  );
}
