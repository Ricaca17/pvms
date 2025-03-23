import React from "react";
import { Card } from "../ui/card";
import { UserPlus } from "lucide-react";

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

export default StatCard;
