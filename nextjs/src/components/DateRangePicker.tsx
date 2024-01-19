import React from 'react';
import { Datepicker } from 'flowbite-react';

export default function DateRangePicker({ setDate }: any) {
  return (
    <div className="flex items-center">
      <Datepicker onSelectedDateChanged={setDate.setStartDate} name="start" />
      <span className="mx-4 text-gray-500">to</span>
      <Datepicker onSelectedDateChanged={setDate.setEndDate} name="end" />
    </div>
  );
}
