import React, { useEffect } from 'react';
import AddBrokerForm from '@/components/AddBrokerForm';
import UserApikeysList from '@/components/UserApiKeyList';
import Breadcumb from '@/components/Breadcumb';
import { user } from '@/config';

const getBrokers = async () => {
  const promise = await fetch('http://127.0.0.1:8000/api/brokers/');
  const brokers = await promise.json();
  return brokers['hydra:member'].map((broker: any) => {
    return {
      id: broker.id,
      name: broker.name
    };
  });
};

const getUserBrokerApiKeys = async (id: any, brokers: any) => {
  const promise = await fetch(`http://localhost:8000/api/users/${id}/brokerApiKeys/`);
  const brokerApiKeys = await promise.json();
  return brokerApiKeys['hydra:member'].map((brokerApiKey: any) => {
    return {
      id: brokerApiKey.id,
      accessKey: brokerApiKey.accessKey,
      broker: brokers.find(
        // populate broker
        (broker: any) => broker.id === Number(brokerApiKey.broker.substr(-1, 1))
      )
    };
  });
};

export default async function page() {
  const brokers = await getBrokers();
  const brokerApiKeys = await getUserBrokerApiKeys(user.id, brokers);
  const handleSubmit = (payload: any) => {
    console.log(payload);
  };

  return (
    <div>
      <Breadcumb links={['App', 'Brokers']} />
      <h2 className="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl dark:text-white">Brokers management</h2>
      <div className="block mb-6 p-6 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700 ">
        <h3 className="text-3xl font-bold dark:text-white mb-4">Add a broker Api</h3>
        <AddBrokerForm brokers={brokers} />
      </div>
      <h3 className="text-3xl font-bold dark:text-white mb-4">My api keys</h3>
      <UserApikeysList brokerApiKeys={brokerApiKeys} />
    </div>
  );
}
