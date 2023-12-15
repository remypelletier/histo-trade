'use client';

import React from 'react';
import { Table } from 'flowbite-react';

export default function UserApiKeyList({ brokerApiKeys }: any) {
  return (
    <div className="overflow-x-auto">
      <Table>
        <Table.Head>
          <Table.HeadCell>Broker</Table.HeadCell>
          <Table.HeadCell>Access key</Table.HeadCell>
          <Table.HeadCell>Secret key</Table.HeadCell>
          <Table.HeadCell>
            <span className="sr-only">Delete</span>
          </Table.HeadCell>
        </Table.Head>
        <Table.Body className="divide-y">
          {brokerApiKeys.map((brokerApiKey: any, index: number) => {
            return (
              <Table.Row key={`odiziodh-${index}`} className="bg-white dark:border-gray-700 dark:bg-gray-800">
                <Table.Cell>{brokerApiKey.broker.name}</Table.Cell>
                <Table.Cell>{brokerApiKey.accessKey}</Table.Cell>
                <Table.Cell>kqopncomqkdpazomls</Table.Cell>
                <Table.Cell>
                  <a href="#" className="font-medium text-red-600 dark:text-red-500 hover:underline">
                    Remove
                  </a>
                </Table.Cell>
              </Table.Row>
            );
          })}
        </Table.Body>
      </Table>
    </div>
  );
}
