import React from "react";
import { Badge } from "../../components/ui/badge";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "../../components/ui/card";
import { Eye } from "lucide-react";

interface ActivityItem {
  visitorName: string;
  prisonerName: string;
  timestamp: string;
  status: "Completed" | "In Progress" | "Scheduled";
  daysAgo: number;
}

interface ActivityListProps {
  activities?: ActivityItem[];
  title?: string;
}

const ActivityList = ({
  activities = [
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
  ],
  title = "Recent Activity",
}: ActivityListProps) => {
  return (
    <Card className="w-full bg-white dark:bg-gray-800 shadow-sm">
      <CardHeader className="pb-2">
        <CardTitle className="text-xl font-bold">{title}</CardTitle>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          {activities.map((activity, index) => (
            <div
              key={index}
              className="p-4 rounded-lg bg-gray-50 dark:bg-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4"
            >
              <div className="space-y-1">
                <p className="font-medium">
                  {activity.visitorName} visited {activity.prisonerName}
                </p>
                <p className="text-sm text-gray-500 dark:text-gray-400">
                  {activity.daysAgo} days ago at {activity.timestamp}
                </p>
              </div>
              <div className="flex items-center gap-3">
                <Badge
                  variant="outline"
                  className={`px-3 py-1 ${
                    activity.status === "Completed"
                      ? "bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300"
                      : activity.status === "In Progress"
                        ? "bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300"
                        : "bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300"
                  }`}
                >
                  {activity.status}
                </Badge>
                <button className="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                  <Eye className="h-4 w-4 text-gray-500 dark:text-gray-400" />
                </button>
              </div>
            </div>
          ))}
        </div>
      </CardContent>
    </Card>
  );
};

export default ActivityList;
