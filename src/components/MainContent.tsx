import React from "react";
import { Card } from "../components/ui/card";
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "../components/ui/tabs";
import { Button } from "../components/ui/button";
import { Input } from "../components/ui/input";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "../components/ui/select";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "../components/ui/table";
import { Badge } from "../components/ui/badge";
import {
  Search,
  Filter,
  UserPlus,
  Eye,
  Edit,
  Trash2,
  Clock,
  Calendar,
} from "lucide-react";

interface MainContentProps {
  title?: string;
  icon?: React.ReactNode;
  children?: React.ReactNode;
}

const MainContent = ({
  title = "Dashboard",
  icon = <Clock className="h-6 w-6 text-blue-600" />,
  children,
}: MainContentProps) => {
  // Default content if no children are provided
  const defaultContent = (
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
          icon={<UserPlus className="h-6 w-6 text-yellow-600" />}
          bgColor="bg-yellow-50"
        />
        <StatCard
          title="Active Visitors"
          value="0"
          icon={<Clock className="h-6 w-6 text-purple-600" />}
          bgColor="bg-purple-50"
        />
      </div>

      {/* Recent Activity Section */}
      <Card className="p-6">
        <div className="flex justify-between items-center mb-6">
          <h2 className="text-xl font-semibold">Recent Activity</h2>
          <Button variant="outline" size="sm">
            View All
          </Button>
        </div>

        <div className="space-y-4">
          <ActivityItem
            visitorName="Miguel Bautista"
            prisonerName="Wilson Dizon"
            timestamp="644 days ago at 11:30 AM"
            status="Completed"
          />
          <ActivityItem
            visitorName="Atty. Juana Reyes"
            prisonerName="Roberto Mendoza"
            timestamp="645 days ago at 02:00 PM"
            status="Completed"
          />
          <ActivityItem
            visitorName="Pedro Santos"
            prisonerName="Juan Dela Cruz"
            timestamp="646 days ago at 10:00 AM"
            status="Completed"
          />
        </div>
      </Card>

      {/* Visitor Management Tabs */}
      <Card className="p-6">
        <Tabs defaultValue="upcoming">
          <div className="flex justify-between items-center mb-6">
            <h2 className="text-xl font-semibold">Visitor Management</h2>
            <TabsList>
              <TabsTrigger value="upcoming">Upcoming</TabsTrigger>
              <TabsTrigger value="past">Past</TabsTrigger>
            </TabsList>
          </div>

          <TabsContent value="upcoming" className="space-y-4">
            <div className="flex justify-between items-center">
              <div className="relative w-64">
                <Search className="absolute left-2 top-2.5 h-4 w-4 text-gray-500" />
                <Input placeholder="Search visitors..." className="pl-8" />
              </div>
              <div className="flex gap-2">
                <Button variant="outline" size="sm">
                  <Filter className="h-4 w-4 mr-2" />
                  Filter
                </Button>
                <Button size="sm">
                  <UserPlus className="h-4 w-4 mr-2" />
                  Add Visitor
                </Button>
              </div>
            </div>

            <div className="rounded-md border">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Visitor</TableHead>
                    <TableHead>Prisoner</TableHead>
                    <TableHead>Date</TableHead>
                    <TableHead>Time</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead className="text-right">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  <TableRow>
                    <TableCell className="font-medium">Maria Santos</TableCell>
                    <TableCell>Juan Dela Cruz</TableCell>
                    <TableCell>Tomorrow</TableCell>
                    <TableCell>10:00 AM</TableCell>
                    <TableCell>
                      <Badge
                        variant="outline"
                        className="bg-blue-50 text-blue-700 hover:bg-blue-50 border-blue-200"
                      >
                        Scheduled
                      </Badge>
                    </TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-2">
                        <Button variant="ghost" size="icon">
                          <Eye className="h-4 w-4" />
                        </Button>
                        <Button variant="ghost" size="icon">
                          <Edit className="h-4 w-4" />
                        </Button>
                        <Button variant="ghost" size="icon">
                          <Trash2 className="h-4 w-4" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                  <TableRow>
                    <TableCell
                      colSpan={6}
                      className="text-center py-8 text-gray-500"
                    >
                      No other upcoming visits scheduled
                    </TableCell>
                  </TableRow>
                </TableBody>
              </Table>
            </div>
          </TabsContent>

          <TabsContent value="past" className="space-y-4">
            <div className="flex justify-between items-center">
              <div className="relative w-64">
                <Search className="absolute left-2 top-2.5 h-4 w-4 text-gray-500" />
                <Input placeholder="Search visitors..." className="pl-8" />
              </div>
              <div className="flex gap-2">
                <Button variant="outline" size="sm">
                  <Filter className="h-4 w-4 mr-2" />
                  Filter
                </Button>
                <Button variant="outline" size="sm">
                  <Calendar className="h-4 w-4 mr-2" />
                  Date Range
                </Button>
              </div>
            </div>

            <div className="rounded-md border">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Visitor</TableHead>
                    <TableHead>Prisoner</TableHead>
                    <TableHead>Date</TableHead>
                    <TableHead>Duration</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead className="text-right">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  <TableRow>
                    <TableCell className="font-medium">
                      Miguel Bautista
                    </TableCell>
                    <TableCell>Wilson Dizon</TableCell>
                    <TableCell>644 days ago</TableCell>
                    <TableCell>1 hour 15 min</TableCell>
                    <TableCell>
                      <Badge
                        variant="outline"
                        className="bg-green-50 text-green-700 hover:bg-green-50 border-green-200"
                      >
                        Completed
                      </Badge>
                    </TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-2">
                        <Button variant="ghost" size="icon">
                          <Eye className="h-4 w-4" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                  <TableRow>
                    <TableCell className="font-medium">
                      Atty. Juana Reyes
                    </TableCell>
                    <TableCell>Roberto Mendoza</TableCell>
                    <TableCell>645 days ago</TableCell>
                    <TableCell>1 hour 15 min</TableCell>
                    <TableCell>
                      <Badge
                        variant="outline"
                        className="bg-green-50 text-green-700 hover:bg-green-50 border-green-200"
                      >
                        Completed
                      </Badge>
                    </TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-2">
                        <Button variant="ghost" size="icon">
                          <Eye className="h-4 w-4" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                  <TableRow>
                    <TableCell className="font-medium">Pedro Santos</TableCell>
                    <TableCell>Juan Dela Cruz</TableCell>
                    <TableCell>646 days ago</TableCell>
                    <TableCell>1 hour 30 min</TableCell>
                    <TableCell>
                      <Badge
                        variant="outline"
                        className="bg-green-50 text-green-700 hover:bg-green-50 border-green-200"
                      >
                        Completed
                      </Badge>
                    </TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-2">
                        <Button variant="ghost" size="icon">
                          <Eye className="h-4 w-4" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                </TableBody>
              </Table>
            </div>
          </TabsContent>
        </Tabs>
      </Card>
    </div>
  );

  return (
    <div className="flex-1 bg-gray-50 p-6 dark:bg-gray-900">
      <div className="flex items-center mb-6">
        <div className="mr-4 p-2 rounded-md bg-blue-100 dark:bg-blue-900">
          {icon}
        </div>
        <h1 className="text-2xl font-bold">{title}</h1>
      </div>

      {children || defaultContent}
    </div>
  );
};

interface StatCardProps {
  title?: string;
  value?: string;
  icon?: React.ReactNode;
  bgColor?: string;
}

const StatCard = ({
  title = "Stat Title",
  value = "0",
  icon = <UserPlus className="h-6 w-6 text-blue-600" />,
  bgColor = "bg-blue-50",
}: StatCardProps) => {
  return (
    <Card className={`p-6 ${bgColor} border-none`}>
      <div className="flex justify-between items-start">
        <div>
          <p className="text-sm font-medium text-gray-600 dark:text-gray-400">
            {title}
          </p>
          <h3 className="text-3xl font-bold mt-2">{value}</h3>
        </div>
        <div className="p-2 rounded-full bg-white dark:bg-gray-800 shadow-sm">
          {icon}
        </div>
      </div>
    </Card>
  );
};

interface ActivityItemProps {
  visitorName?: string;
  prisonerName?: string;
  timestamp?: string;
  status?: string;
}

const ActivityItem = ({
  visitorName = "Visitor Name",
  prisonerName = "Prisoner Name",
  timestamp = "Time",
  status = "Pending",
}: ActivityItemProps) => {
  return (
    <div className="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 flex justify-between items-center">
      <div>
        <p className="font-medium">
          {visitorName} visited {prisonerName}
        </p>
        <p className="text-sm text-gray-500">{timestamp}</p>
      </div>
      <Badge
        variant="outline"
        className={
          status === "Completed"
            ? "bg-green-50 text-green-700 hover:bg-green-50 border-green-200"
            : "bg-blue-50 text-blue-700 hover:bg-blue-50 border-blue-200"
        }
      >
        {status}
      </Badge>
    </div>
  );
};

export default MainContent;
