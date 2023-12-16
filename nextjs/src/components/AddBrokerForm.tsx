'use client';

import React, { useState } from 'react';
import { Label, Select, Button, TextInput } from 'flowbite-react';
import { user, api } from '@/config';
import { toast } from 'react-toastify';

export default function AddBrokerForm({ brokers, brokerApiKeys, mutate }: any) {
  const [selectedBroker, setSelectedBroker] = useState(brokers[0].id);
  const [accessKey, setAccessKey] = useState('');
  const [secretKey, setSecretKey] = useState('');

  const handleSubmit = (e: any) => {
    e.preventDefault();
    const formData = {
      accessKey: accessKey,
      secretKey: secretKey,
      broker: `/api/brokers/${selectedBroker}`,
      user: `/api/users/${user.id}` // TODO: authenticated user
    };
    const requestConfig = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/ld+json'
      },
      body: JSON.stringify(formData)
    };
    fetch(`${api.baseUrl}/api/broker_api_keys`, requestConfig)
      .then(res => {
        return res.json();
      })
      .then(res => {
        delete res['@context'];
        brokerApiKeys['hydra:member'].push(res);
        mutate(brokerApiKeys);
        toast.success('Api key successfully added!', {
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
    <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
      {/* Select Broker */}
      <div>
        <div className="mb-2 block">
          <Label htmlFor="brokers" value="Select your broker" />
        </div>
        <Select name="brokers" id="brokers" value={selectedBroker} onChange={e => setSelectedBroker(e.target.value)} required>
          {brokers.map((broker: any) => (
            <option key={broker.id} value={broker.id}>
              {broker.name}
            </option>
          ))}
        </Select>
      </div>

      {/* Key Name */}
      <div>
        <div className="mb-2 block">
          <Label htmlFor="accessKey" value="Key name" />
        </div>
        <TextInput name="accessKey" id="accessKey" type="text" value={accessKey} onChange={e => setAccessKey(e.target.value)} required />
      </div>

      {/* Key Secret */}
      <div>
        <div className="mb-2 block">
          <Label htmlFor="secretKey" value="Key secret" />
        </div>
        <TextInput name="secretKey" id="secretKey" type="password" value={secretKey} onChange={e => setSecretKey(e.target.value)} required />
      </div>

      {/* Submit Button */}
      <Button color="blue" type="submit">
        Submit
      </Button>
    </form>
  );
}
