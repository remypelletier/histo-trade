'use client';

import React from 'react';
import { Table } from 'flowbite-react';
import { toast } from 'react-toastify';
import { api } from '@/config';

export default function UserApiKeyList({ brokerApiKeys, brokers, mutate }: any) {
  const handleDelete = (id: any) => {
    const requestConfig = {
      method: 'DELETE'
    };
    fetch(`${api.baseUrl}/api/broker_api_keys/${id}`, requestConfig).then(res => {
      brokerApiKeys['hydra:member'] = brokerApiKeys['hydra:member'].filter((brokerApiKey: any) => brokerApiKey.id !== id);
      mutate(brokerApiKeys);
      toast.success('Api key successfully removed!', {
        position: 'bottom-center',
        autoClose: 3000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: false,
        progress: 0.3,
        theme: 'dark'
      });
    });
  };

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
          {brokerApiKeys &&
            brokerApiKeys['hydra:member'].map((brokerApiKey: any, index: number) => {
              const broker = brokers.find(broker => broker.id === Number(brokerApiKey.broker.substr(-1, 1)));
              return (
                <Table.Row key={`odiziodh-${index}`} className="bg-white dark:border-gray-700 dark:bg-gray-800">
                  <Table.Cell>{broker.name}</Table.Cell>
                  <Table.Cell>{brokerApiKey.accessKey}</Table.Cell>
                  <Table.Cell>kqopncomqkdpazomls</Table.Cell>
                  <Table.Cell>
                    <button onClick={() => handleDelete(brokerApiKey.id)} className="font-medium text-red-600 dark:text-red-500 hover:underline">
                      Delete
                    </button>
                  </Table.Cell>
                </Table.Row>
              );
            })}
        </Table.Body>
      </Table>
    </div>
  );
}
