import React, { useState } from "react";
import Layout from "../components/Layout";
import { Button } from "../components/ui/button";
import { Input } from "../components/ui/input";
import { Badge } from "../components/ui/badge";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "../components/ui/table";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "../components/ui/select";
import {
  Search,
  Filter,
  UserPlus,
  Eye,
  Edit,
  Trash2,
  Calendar,
} from "lucide-react";

interface Visit {
  id: string;
  visitorName: string;
  prisonerName: string;
  date: string;
  time: string;
  duration: string;
  status: "Scheduled" | "In Progress" | "Completed" | "Cancelled";
  purpose: string;
}

const VisitorsLog = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [statusFilter, setStatusFilter] = useState<string>("all");

  // Mock data for visits
  const visits: Visit[] = [
    {
      id: "V001",
      visitorName: "Miguel Bautista",
      prisonerName: "Wilson Dizon",
      date: "644 days ago",
      time: "11:30 AM",
      duration: "1 hour 15 min",
      status: "Completed",
      purpose: "Family visit",
    },
    {
      id: "V002",
      visitorName: "Atty. Juana Reyes",
      prisonerName: "Roberto Mendoza",
      date: "645 days ago",
      time: "02:00 PM",
      duration: "1 hour",
      status: "Completed",
      purpose: "Legal consultation",
    },
    {
      id: "V003",
      visitorName: "Pedro Santos",
      prisonerName: "Juan Dela Cruz",
      date: "646 days ago",
      time: "10:00 AM",
      duration: "1 hour 30 min",
      status: "Completed",
      purpose: "Family visit",
    },
    {
      id: "V004",
      visitorName: "Maria Santos",
      prisonerName: "Juan Dela Cruz",
      date: "Tomorrow",
      time: "10:00 AM",
      duration: "1 hour",
      status: "Scheduled",
      purpose: "Family visit",
    },
  ];

  // Filter visits based on search term and status filter
  const filteredVisits = visits.filter((visit) => {
    const matchesSearch =
      visit.visitorName.toLowerCase().includes(searchTerm.toLowerCase()) ||
      visit.prisonerName.toLowerCase().includes(searchTerm.toLowerCase());

    const matchesStatus =
      statusFilter === "all" || visit.status === statusFilter;

    return matchesSearch && matchesStatus;
  });

  return (
    <Layout title="Visitors Log">
      <div className="space-y-6">
        {/* Header with search and actions */}
        <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div className="relative w-full sm:w-64">
            <Search className="absolute left-2 top-2.5 h-4 w-4 text-gray-500" />
            <Input
              placeholder="Search visitors or prisoners..."
              className="pl-8"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
          </div>
          <div className="flex flex-wrap gap-2 w-full sm:w-auto">
            <Select value={statusFilter} onValueChange={setStatusFilter}>
              <SelectTrigger className="w-[180px]">
                <SelectValue placeholder="Filter by status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Statuses</SelectItem>
                <SelectItem value="Scheduled">Scheduled</SelectItem>
                <SelectItem value="In Progress">In Progress</SelectItem>
                <SelectItem value="Completed">Completed</SelectItem>
                <SelectItem value="Cancelled">Cancelled</SelectItem>
              </SelectContent>
            </Select>
            <Button variant="outline" size="icon">
              <Calendar className="h-4 w-4" />
            </Button>
            <Button>
              <UserPlus className="h-4 w-4 mr-2" />
              New Visit
            </Button>
          </div>
        </div>

        {/* Visitors table */}
        <div className="rounded-md border bg-white">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Visitor</TableHead>
                <TableHead>Prisoner</TableHead>
                <TableHead>Date</TableHead>
                <TableHead>Time</TableHead>
                <TableHead>Duration</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Purpose</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredVisits.length > 0 ? (
                filteredVisits.map((visit) => (
                  <TableRow key={visit.id}>
                    <TableCell className="font-medium">
                      {visit.visitorName}
                    </TableCell>
                    <TableCell>{visit.prisonerName}</TableCell>
                    <TableCell>{visit.date}</TableCell>
                    <TableCell>{visit.time}</TableCell>
                    <TableCell>{visit.duration}</TableCell>
                    <TableCell>
                      <Badge
                        variant="outline"
                        className={`
                          ${visit.status === "Completed" ? "bg-green-50 text-green-700 border-green-200" : ""}
                          ${visit.status === "Scheduled" ? "bg-blue-50 text-blue-700 border-blue-200" : ""}
                          ${visit.status === "In Progress" ? "bg-yellow-50 text-yellow-700 border-yellow-200" : ""}
                          ${visit.status === "Cancelled" ? "bg-red-50 text-red-700 border-red-200" : ""}
                        `}
                      >
                        {visit.status}
                      </Badge>
                    </TableCell>
                    <TableCell>{visit.purpose}</TableCell>
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
                ))
              ) : (
                <TableRow>
                  <TableCell
                    colSpan={8}
                    className="text-center py-8 text-gray-500"
                  >
                    No visits found matching your filters
                  </TableCell>
                </TableRow>
              )}
            </TableBody>
          </Table>
        </div>
      </div>
    </Layout>
  );
};

export default VisitorsLog;
