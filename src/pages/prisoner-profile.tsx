import React, { useState } from "react";
import { Button } from "../components/ui/button";
import { Card } from "../components/ui/card";
import { Badge } from "../components/ui/badge";
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "../components/ui/tabs";
import { Edit, Plus, FileText } from "lucide-react";
import { Separator } from "../components/ui/separator";
import { User } from "lucide-react";

interface PrisonerProfileProps {
  prisoner?: {
    id: string;
    name: string;
    age: number;
    gender: string;
    cell: string;
    sentence: string;
    crime: string;
    admissionDate: string;
    releaseDate: string;
    status: string;
    securityLevel: string;
    healthStatus: string;
    emergencyContact: string;
  };
  visitorHistory?: Array<{
    name: string;
    relationship: string;
    date: string;
    duration: string;
  }>;
  behaviorRecord?: Array<{
    description: string;
    date: string;
    type: "positive" | "negative";
  }>;
}

const PrisonerProfile = ({
  prisoner = {
    id: "P001",
    name: "Juan Dela Cruz",
    age: 35,
    gender: "Male",
    cell: "Block A-101",
    sentence: "5 years",
    crime: "Fraud",
    admissionDate: "2020-03-15",
    releaseDate: "2025-03-15",
    status: "Incarcerated",
    securityLevel: "Medium",
    healthStatus: "Good",
    emergencyContact: "Maria Dela Cruz (Wife) - 555-123-4567",
  },
  visitorHistory = [
    {
      name: "Pedro Santos",
      relationship: "Family",
      date: "June 15, 2023",
      duration: "1.5 hours",
    },
    {
      name: "Atty. Juana Reyes",
      relationship: "Legal",
      date: "May 10, 2023",
      duration: "1 hour",
    },
  ],
  behaviorRecord = [
    {
      description: "Good behavior - Participated in community service",
      date: "June 1, 2023",
      type: "positive",
    },
    {
      description: "Verbal altercation with another inmate",
      date: "April 15, 2023",
      type: "negative",
    },
  ],
}: PrisonerProfileProps) => {
  const [activeTab, setActiveTab] = useState("info");

  return (
    <div className="flex-1 bg-gray-50 p-6 dark:bg-gray-900">
      {/* Header with title and actions */}
      <div className="flex items-center justify-between mb-6">
        <div className="flex items-center">
          <div className="mr-4 p-2 rounded-md bg-blue-100 dark:bg-blue-900">
            <User className="h-6 w-6 text-blue-600" />
          </div>
          <h1 className="text-2xl font-bold">Prisoner Profile</h1>
        </div>
        <div className="flex gap-2">
          <Button variant="outline">
            <Edit className="h-4 w-4 mr-2" />
            Edit Profile
          </Button>
          <Button>
            <Plus className="h-4 w-4 mr-2" />
            Add Behavior
          </Button>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Left column - Prisoner basic info */}
        <Card className="p-6 col-span-1">
          <div className="flex flex-col items-center mb-6">
            <div className="w-24 h-24 rounded-full overflow-hidden mb-4">
              <img
                src={`https://api.dicebear.com/7.x/avataaars/svg?seed=${prisoner.name}`}
                alt={prisoner.name}
                className="w-full h-full object-cover"
              />
            </div>
            <h2 className="text-xl font-bold">{prisoner.name}</h2>
            <p className="text-sm text-gray-500">ID: {prisoner.id}</p>
            <Badge
              variant="outline"
              className="mt-2 bg-green-50 text-green-700 hover:bg-green-50 border-green-200"
            >
              {prisoner.status}
            </Badge>
          </div>

          <div className="space-y-4">
            <div className="flex items-center">
              <User className="h-4 w-4 text-gray-500 mr-2" />
              <span className="text-sm text-gray-500">Age / Gender</span>
              <span className="ml-auto font-medium">
                {prisoner.age} / {prisoner.gender}
              </span>
            </div>

            <Separator />

            <div className="flex items-start">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="text-gray-500 mr-2 mt-0.5"
              >
                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                <circle cx="12" cy="10" r="3" />
              </svg>
              <span className="text-sm text-gray-500">Cell</span>
              <span className="ml-auto font-medium">{prisoner.cell}</span>
            </div>

            <Separator />

            <div className="flex items-start">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="text-gray-500 mr-2 mt-0.5"
              >
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
              </svg>
              <span className="text-sm text-gray-500">Sentence</span>
              <span className="ml-auto font-medium">{prisoner.sentence}</span>
            </div>

            <Separator />

            <div className="flex items-start">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="text-gray-500 mr-2 mt-0.5"
              >
                <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4" />
                <path d="M2 7h20" />
                <path d="M22 7v3a2 2 0 0 1-2 2v0a2 2 0 0 1-2-2v0" />
              </svg>
              <span className="text-sm text-gray-500">Crime</span>
              <span className="ml-auto font-medium">{prisoner.crime}</span>
            </div>

            <Separator />

            <div className="flex items-start">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="text-gray-500 mr-2 mt-0.5"
              >
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                <line x1="16" x2="16" y1="2" y2="6" />
                <line x1="8" x2="8" y1="2" y2="6" />
                <line x1="3" x2="21" y1="10" y2="10" />
              </svg>
              <span className="text-sm text-gray-500">Admission Date</span>
              <span className="ml-auto font-medium">
                {prisoner.admissionDate}
              </span>
            </div>

            <Separator />

            <div className="flex items-start">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="text-gray-500 mr-2 mt-0.5"
              >
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                <line x1="16" x2="16" y1="2" y2="6" />
                <line x1="8" x2="8" y1="2" y2="6" />
                <line x1="3" x2="21" y1="10" y2="10" />
              </svg>
              <span className="text-sm text-gray-500">Release Date</span>
              <span className="ml-auto font-medium">
                {prisoner.releaseDate}
              </span>
            </div>
          </div>
        </Card>

        {/* Right column - Detailed information */}
        <div className="col-span-1 lg:col-span-2 space-y-6">
          {/* Security & Health */}
          <Card className="p-6">
            <h2 className="text-lg font-semibold mb-4">Security & Health</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <p className="text-sm text-gray-500">Security Level</p>
                <p className="font-medium">{prisoner.securityLevel}</p>
              </div>
              <div>
                <p className="text-sm text-gray-500">Health Status</p>
                <p className="font-medium">{prisoner.healthStatus}</p>
              </div>
              <div className="md:col-span-2">
                <p className="text-sm text-gray-500">Emergency Contact</p>
                <p className="font-medium">{prisoner.emergencyContact}</p>
              </div>
            </div>
          </Card>

          {/* Visitor History */}
          <Card className="p-6">
            <div className="flex justify-between items-center mb-4">
              <h2 className="text-lg font-semibold">Visitor History</h2>
              <Button variant="ghost" size="sm" className="h-8 gap-1">
                <User className="h-4 w-4" />
                <span className="sr-only sm:not-sr-only">All Visitors</span>
              </Button>
            </div>

            <div className="space-y-4">
              {visitorHistory.map((visitor, index) => (
                <div
                  key={index}
                  className="flex justify-between items-start p-3 bg-gray-50 rounded-md"
                >
                  <div>
                    <p className="font-medium">{visitor.name}</p>
                    <p className="text-sm text-gray-500">
                      {visitor.relationship}
                    </p>
                  </div>
                  <div className="text-right">
                    <p className="text-sm">{visitor.date}</p>
                    <p className="text-sm text-gray-500">
                      Duration: {visitor.duration}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          </Card>

          {/* Behavior Record */}
          <Card className="p-6">
            <div className="flex justify-between items-center mb-4">
              <h2 className="text-lg font-semibold">Behavior Record</h2>
              <Button variant="ghost" size="sm" className="h-8 gap-1">
                <FileText className="h-4 w-4" />
                <span className="sr-only sm:not-sr-only">Full Report</span>
              </Button>
            </div>

            <div className="space-y-4">
              {behaviorRecord.map((record, index) => (
                <div
                  key={index}
                  className={`flex justify-between items-start p-3 rounded-md ${record.type === "positive" ? "bg-green-50" : "bg-red-50"}`}
                >
                  <p className="font-medium">{record.description}</p>
                  <p className="text-sm text-gray-500">{record.date}</p>
                </div>
              ))}
            </div>
          </Card>
        </div>
      </div>
    </div>
  );
};

export default PrisonerProfile;
