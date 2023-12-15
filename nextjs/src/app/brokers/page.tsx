"use client";

import React from "react";
import { Label, Select, Button, TextInput } from "flowbite-react";

export default function page() {
  const brokers = [
    { id: "0", name: "MEXC" },
    { id: "2", name: "BINANCE" },
    { id: "3", name: "BYBIT" },
    { id: "4", name: "FTX" },
  ];

  const handleSubmit = (e: any) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    console.log(formData.get("brokers"));
    console.log(formData.get("keyName"));
    console.log(formData.get("keySecret"));
  };

  return (
    <div>
      <form className="flex max-w-md flex-col gap-4" onSubmit={handleSubmit}>
        <div>
          <div className="mb-2 block">
            <Label htmlFor="brokers" value="Select your broker" />
          </div>
          <Select name="brokers" id="brokers" required>
            {brokers.map((broker) => {
              return <option value={broker.id}>{broker.name}</option>;
            })}
          </Select>
        </div>
        <div>
          <div className="mb-2 block">
            <Label htmlFor="keyName" value="Key name" />
          </div>
          <TextInput
            name="keyName"
            id="keyName"
            type="text"
            placeholder="..."
            required
          />
        </div>
        <div>
          <div className="mb-2 block">
            <Label htmlFor="keySecret" value="Key secret" />
          </div>
          <TextInput name="keySecret" id="keySecret" type="password" required />
        </div>
        <Button color="blue" type="submit">
          Submit
        </Button>
      </form>
    </div>
  );
}
