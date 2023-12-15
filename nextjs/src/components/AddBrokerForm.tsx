'use client';

import React, { useState } from 'react';
import { Label, Select, Button, TextInput } from 'flowbite-react';

export default function AddBrokerForm({ brokers, handleSubmit }: any) {
  const [selectedBroker, setSelectedBroker] = useState(brokers[0].id);
  const [keyName, setKeyName] = useState('');
  const [keySecret, setKeySecret] = useState('');

  const handleValidations = (e: any) => {
    e.preventDefault();
    const formData = {
      keyName: keyName,
      keySecret: keySecret,
      brokerId: Number(selectedBroker)
    };
    handleSubmit(formData);
  };

  return (
    <form className="flex flex-col gap-4" onSubmit={handleValidations}>
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
          <Label htmlFor="keyName" value="Key name" />
        </div>
        <TextInput name="keyName" id="keyName" type="text" value={keyName} onChange={e => setKeyName(e.target.value)} required />
      </div>

      {/* Key Secret */}
      <div>
        <div className="mb-2 block">
          <Label htmlFor="keySecret" value="Key secret" />
        </div>
        <TextInput name="keySecret" id="keySecret" type="password" value={keySecret} onChange={e => setKeySecret(e.target.value)} required />
      </div>

      {/* Submit Button */}
      <Button color="blue" type="submit">
        Submit
      </Button>
    </form>
  );
}
