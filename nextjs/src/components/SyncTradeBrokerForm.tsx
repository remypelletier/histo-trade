import React, { useState } from 'react';
import { Label, Select, Button, TextInput } from 'flowbite-react';

export default function SyncTradeBrokerForm({ brokerApiKeys, brokers }: any) {
  const [selectedApi, setSelectedApi] = useState('');
  const handleSubmit = e => {
    e.preventDefault();
    const apikey = brokerApiKeys['hydra:member'].find(brokerApiKey => brokerApiKey.id === Number(selectedApi));
    const broker = brokers.find(broker => broker.id === Number(apikey.broker.substr(-1, 1)));
    console.log(apikey.secretKey);
    console.log(apikey.accessKey);
    console.log(broker.name);
    // TODO: call to api from the selected broker
    // populate trades database
  };
  return (
    <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
      {/* Select Broker */}
      <div>
        <div className="mb-2 block">
          <Label htmlFor="brokerApiKey" value="Select your Api" />
        </div>
        <Select name="brokerApiKey" id="brokerApiKey" value={selectedApi} onChange={e => setSelectedApi(e.target.value)} required>
          {brokerApiKeys &&
            brokerApiKeys['hydra:member'].map((brokerApiKey: any, index: number) => {
              const broker = brokers.find(broker => broker.id === Number(brokerApiKey.broker.substr(-1, 1)));
              return (
                <option key={brokerApiKey.id} value={brokerApiKey.id}>
                  {broker.name} - {brokerApiKey.accessKey}
                </option>
              );
            })}
        </Select>
      </div>

      {/* Submit Button */}
      <Button color="blue" type="submit">
        Sync
      </Button>
    </form>
  );
}
