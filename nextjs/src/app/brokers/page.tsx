'use client';

import React, { useEffect } from 'react';
import AddBrokerForm from '@/components/AddBrokerForm';
import UserApikeysList from '@/components/UserApiKeyList';
import Breadcumb from '@/components/Breadcumb';
import SyncTradeBrokerForm from '@/components/SyncTradeBrokerForm';
import { user, api } from '@/config';

import useSWR from 'swr';

const fetcher = (...args) => fetch(...args).then(res => res.json());

const useBrokers = () => {
  const { data, error } = useSWR(`${api.baseUrl}/api/brokers/`, fetcher);

  const brokers = data
    ? data['hydra:member'].map(broker => ({
        id: broker.id,
        name: broker.name
      }))
    : [];

  return {
    brokers,
    isLoading: !error && !data,
    isError: error
  };
};

const useUserBrokerApiKeys = id => {
  const { brokers } = useBrokers(); // Utilisation du hook useBrokers
  const { data, error, mutate } = useSWR(`${api.baseUrl}/api/users/${id}/brokerApiKeys/`, fetcher);

  return {
    mutate,
    brokerApiKeys: data,
    isLoading: !error && !data,
    isError: error
  };
};

export default function page() {
  const { brokers, isLoading: isLoadingBrokers, isError: isErrorBrokers } = useBrokers();
  const { brokerApiKeys, isLoading: isLoadingBrokerApiKeys, isError: isErrorBrokerApiKeys, mutate } = useUserBrokerApiKeys(user.id);

  if (isLoadingBrokers && isLoadingBrokerApiKeys) return <div>Loading...</div>;
  if (isErrorBrokers && isErrorBrokerApiKeys) return <div>Error</div>;

  return (
    <div>
      <Breadcumb links={['App', 'Brokers']} />
      <h2 className="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl dark:text-white">Brokers management</h2>
      <div className="block mb-6 p-6 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700 ">
        <h3 className="text-3xl font-bold dark:text-white mb-4">Add a broker Api</h3>
        <AddBrokerForm brokers={brokers} brokerApiKeys={brokerApiKeys} mutate={mutate} />
      </div>
      <h3 className="text-3xl font-bold dark:text-white mb-4">My api keys</h3>
      <UserApikeysList brokerApiKeys={brokerApiKeys} brokers={brokers} mutate={mutate} />
      <h3 className="text-3xl font-bold dark:text-white mb-4 mt-6">Sync trades</h3>
      <SyncTradeBrokerForm brokerApiKeys={brokerApiKeys} brokers={brokers} />
    </div>
  );
}
