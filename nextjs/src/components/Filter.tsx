import React, { useState } from 'react';
import DateRangePicker from './DateRangePicker';
import { Button } from 'flowbite-react';

export default function Filter() {
  const [startDate, setStartDate] = useState(null);
  const [endDate, setEndDate] = useState(null);

  const handleClick = () => {
    console.log('click');
    console.log(startDate);
    console.log(endDate);
  };
  return (
    <div className="flex pb-4">
      <DateRangePicker setDate={{ setStartDate, setEndDate }} />
      <Button onClick={handleClick} className="ml-5" color="blue">
        Validate
      </Button>
    </div>
  );
}
