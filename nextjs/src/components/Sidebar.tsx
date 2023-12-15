"use client";

import { Sidebar } from "flowbite-react";
import { BiBuoy } from "react-icons/bi";
import {
  HiArrowSmRight,
  HiChartPie,
  HiInbox,
  HiShoppingBag,
  HiTable,
  HiUser,
  HiViewBoards,
} from "react-icons/hi";
import Link from "next/link";

export default function Component() {
  return (
    <Sidebar
      className="fixed top-0 left-0 z-40 w-64 h-screen pt-[65px] bg-w transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
      aria-label="Sidebar with content separator example"
    >
      <div
        className="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800"
        style={{ backgroundColor: "white !important" }}
      >
        <Sidebar.Items>
          <Sidebar.ItemGroup>
            <Sidebar.Item href="/" icon={HiChartPie}>
              Dashboard
            </Sidebar.Item>
            <Sidebar.Item href="/brokers" icon={HiViewBoards}>
              Brokers
            </Sidebar.Item>
            <Sidebar.Item href="/trades" icon={HiInbox}>
              Trades
            </Sidebar.Item>
            <Sidebar.Item href="#" icon={HiUser}>
              Settings
            </Sidebar.Item>
            <Sidebar.Item href="#" icon={HiTable}>
              Logout
            </Sidebar.Item>
          </Sidebar.ItemGroup>
        </Sidebar.Items>
      </div>
    </Sidebar>
  );
}
