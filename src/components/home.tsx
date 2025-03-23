import React from "react";
import Layout from "./Layout";
import { Card } from "./ui/card";
import { Button } from "./ui/button";
import { UserPlus, Users, Clock } from "lucide-react";
import {
  AreaChart,
  Area,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  BarChart,
  Bar,
  Legend,
} from "recharts";

// Import the default export from StatCard
import StatCard from "./dashboard/StatCard";
import ActivityList from "./dashboard/ActivityList";

interface HomeProps {
  title?: string;
}

const Home = ({ title = "Dashboard" }: HomeProps) => {
  // Mock data for charts
  const visitorData = [
    { name: "Jan", visitors: 65 },
    { name: "Feb", visitors: 59 },
    { name: "Mar", visitors: 80 },
    { name: "Apr", visitors: 81 },
    { name: "May", visitors: 56 },
    { name: "Jun", visitors: 55 },
    { name: "Jul", visitors: 40 },
  ];

  const prisonerData = [
    { name: "Block A", count: 12 },
    { name: "Block B", count: 19 },
    { name: "Block C", count: 15 },
    { name: "Block D", count: 8 },
  ];

  // Mock data for recent activities
  const recentActivities = [
    {
      visitorName: "Miguel Bautista",
      prisonerName: "Wilson Dizon",
      timestamp: "11:30 AM",
      status: "Completed",
      daysAgo: 644,
    },
    {
      visitorName: "Atty. Juana Reyes",
      prisonerName: "Roberto Mendoza",
      timestamp: "02:00 PM",
      status: "Completed",
      daysAgo: 645,
    },
    {
      visitorName: "Pedro Santos",
      prisonerName: "Juan Dela Cruz",
      timestamp: "10:00 AM",
      status: "Completed",
      daysAgo: 646,
    },
  ];

  return (
    <Layout title={title}>
      <div className="space-y-6">
        {/* Stats Cards Row */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <StatCard
            title="Total Visitors"
            value="3"
            icon={<UserPlus className="h-6 w-6 text-blue-600" />}
            bgColor="bg-blue-50"
          />
          <StatCard
            title="Total Prisoners"
            value="7"
            icon={<Users className="h-6 w-6 text-yellow-600" />}
            bgColor="bg-yellow-50"
          />
          <StatCard
            title="Active Visitors"
            value="0"
            icon={<Clock className="h-6 w-6 text-purple-600" />}
            bgColor="bg-purple-50"
          />
        </div>

        {/* Charts Section */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <Card className="p-6 bg-white dark:bg-gray-800">
            <h2 className="text-xl font-semibold mb-4">Visitor Trends</h2>
            <div className="h-80">
              <ResponsiveContainer width="100%" height="100%">
                <AreaChart
                  data={visitorData}
                  margin={{ top: 10, right: 30, left: 0, bottom: 0 }}
                >
                  <CartesianGrid strokeDasharray="3 3" opacity={0.1} />
                  <XAxis dataKey="name" />
                  <YAxis />
                  <Tooltip />
                  <Area
                    type="monotone"
                    dataKey="visitors"
                    stroke="#3b82f6"
                    fill="#93c5fd"
                    fillOpacity={0.8}
                  />
                </AreaChart>
              </ResponsiveContainer>
            </div>
          </Card>

          <Card className="p-6 bg-white dark:bg-gray-800">
            <h2 className="text-xl font-semibold mb-4">
              Prisoner Distribution
            </h2>
            <div className="h-80">
              <ResponsiveContainer width="100%" height="100%">
                <BarChart
                  data={prisonerData}
                  margin={{ top: 10, right: 30, left: 0, bottom: 0 }}
                >
                  <CartesianGrid strokeDasharray="3 3" opacity={0.1} />
                  <XAxis dataKey="name" />
                  <YAxis />
                  <Tooltip />
                  <Legend />
                  <Bar
                    dataKey="count"
                    name="Prisoners"
                    fill="#eab308"
                    radius={[4, 4, 0, 0]}
                  />
                </BarChart>
              </ResponsiveContainer>
            </div>
          </Card>
        </div>

        {/* Recent Activity Section */}
        <ActivityList activities={recentActivities} title="Recent Activity" />

        {/* Quick Actions */}
        <Card className="p-6 bg-white dark:bg-gray-800">
          <h2 className="text-xl font-semibold mb-4">Quick Actions</h2>
          <div className="flex flex-wrap gap-4">
            <Button className="bg-blue-600 hover:bg-blue-700">
              <UserPlus className="h-4 w-4 mr-2" />
              Register New Visitor
            </Button>
            <Button variant="outline">
              <Clock className="h-4 w-4 mr-2" />
              View Visitor Log
            </Button>
            <Button variant="outline">
              <Users className="h-4 w-4 mr-2" />
              Manage Prisoners
            </Button>
          </div>
        </Card>
      </div>
    </Layout>
  );
};

export default Home;
