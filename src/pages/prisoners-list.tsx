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
import { Search, Filter, UserPlus2, Eye, Edit, Trash2 } from "lucide-react";

interface Prisoner {
  id: string;
  name: string;
  age: number;
  gender: string;
  cell: string;
  crime: string;
  sentence: string;
  admissionDate: string;
  releaseDate: string;
  status: "Incarcerated" | "Released" | "Transferred" | "Paroled";
  securityLevel: "Low" | "Medium" | "High" | "Maximum";
}

const PrisonersList = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [statusFilter, setStatusFilter] = useState<string>("all");
  const [securityFilter, setSecurityFilter] = useState<string>("all");

  // Mock data for prisoners
  const prisoners: Prisoner[] = [
    {
      id: "P001",
      name: "Juan Dela Cruz",
      age: 35,
      gender: "Male",
      cell: "Block A-101",
      crime: "Fraud",
      sentence: "5 years",
      admissionDate: "2020-03-15",
      releaseDate: "2025-03-15",
      status: "Incarcerated",
      securityLevel: "Medium",
    },
    {
      id: "P002",
      name: "Wilson Dizon",
      age: 42,
      gender: "Male",
      cell: "Block B-205",
      crime: "Robbery",
      sentence: "8 years",
      admissionDate: "2018-07-22",
      releaseDate: "2026-07-22",
      status: "Incarcerated",
      securityLevel: "High",
    },
    {
      id: "P003",
      name: "Roberto Mendoza",
      age: 29,
      gender: "Male",
      cell: "Block A-115",
      crime: "Drug possession",
      sentence: "3 years",
      admissionDate: "2021-01-10",
      releaseDate: "2024-01-10",
      status: "Incarcerated",
      securityLevel: "Low",
    },
    {
      id: "P004",
      name: "Carlos Reyes",
      age: 38,
      gender: "Male",
      cell: "Block C-302",
      crime: "Assault",
      sentence: "4 years",
      admissionDate: "2020-09-05",
      releaseDate: "2024-09-05",
      status: "Incarcerated",
      securityLevel: "Medium",
    },
    {
      id: "P005",
      name: "Eduardo Santos",
      age: 45,
      gender: "Male",
      cell: "Block D-401",
      crime: "Murder",
      sentence: "25 years",
      admissionDate: "2015-11-30",
      releaseDate: "2040-11-30",
      status: "Incarcerated",
      securityLevel: "Maximum",
    },
    {
      id: "P006",
      name: "Fernando Lopez",
      age: 33,
      gender: "Male",
      cell: "Block B-210",
      crime: "Theft",
      sentence: "2 years",
      admissionDate: "2022-02-15",
      releaseDate: "2024-02-15",
      status: "Incarcerated",
      securityLevel: "Low",
    },
    {
      id: "P007",
      name: "Gabriel Torres",
      age: 27,
      gender: "Male",
      cell: "Block A-105",
      crime: "Fraud",
      sentence: "3 years",
      admissionDate: "2021-05-20",
      releaseDate: "2024-05-20",
      status: "Incarcerated",
      securityLevel: "Medium",
    },
  ];

  // Filter prisoners based on search term and filters
  const filteredPrisoners = prisoners.filter((prisoner) => {
    const matchesSearch = prisoner.name
      .toLowerCase()
      .includes(searchTerm.toLowerCase());

    const matchesStatus =
      statusFilter === "all" || prisoner.status === statusFilter;

    const matchesSecurity =
      securityFilter === "all" || prisoner.securityLevel === securityFilter;

    return matchesSearch && matchesStatus && matchesSecurity;
  });

  return (
    <Layout title="Prisoners List">
      <div className="space-y-6">
        {/* Header with search and actions */}
        <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div className="relative w-full sm:w-64">
            <Search className="absolute left-2 top-2.5 h-4 w-4 text-gray-500" />
            <Input
              placeholder="Search prisoners..."
              className="pl-8"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
          </div>
          <div className="flex flex-wrap gap-2 w-full sm:w-auto">
            <Select value={statusFilter} onValueChange={setStatusFilter}>
              <SelectTrigger className="w-[180px]">
                <SelectValue placeholder="Status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Statuses</SelectItem>
                <SelectItem value="Incarcerated">Incarcerated</SelectItem>
                <SelectItem value="Released">Released</SelectItem>
                <SelectItem value="Transferred">Transferred</SelectItem>
                <SelectItem value="Paroled">Paroled</SelectItem>
              </SelectContent>
            </Select>

            <Select value={securityFilter} onValueChange={setSecurityFilter}>
              <SelectTrigger className="w-[180px]">
                <SelectValue placeholder="Security Level" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Levels</SelectItem>
                <SelectItem value="Low">Low</SelectItem>
                <SelectItem value="Medium">Medium</SelectItem>
                <SelectItem value="High">High</SelectItem>
                <SelectItem value="Maximum">Maximum</SelectItem>
              </SelectContent>
            </Select>

            <Button>
              <UserPlus2 className="h-4 w-4 mr-2" />
              Add Prisoner
            </Button>
          </div>
        </div>

        {/* Prisoners table */}
        <div className="rounded-md border bg-white">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>ID</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>Age</TableHead>
                <TableHead>Cell</TableHead>
                <TableHead>Crime</TableHead>
                <TableHead>Sentence</TableHead>
                <TableHead>Release Date</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Security</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredPrisoners.length > 0 ? (
                filteredPrisoners.map((prisoner) => (
                  <TableRow key={prisoner.id}>
                    <TableCell>{prisoner.id}</TableCell>
                    <TableCell className="font-medium">
                      {prisoner.name}
                    </TableCell>
                    <TableCell>{prisoner.age}</TableCell>
                    <TableCell>{prisoner.cell}</TableCell>
                    <TableCell>{prisoner.crime}</TableCell>
                    <TableCell>{prisoner.sentence}</TableCell>
                    <TableCell>{prisoner.releaseDate}</TableCell>
                    <TableCell>
                      <Badge
                        variant="outline"
                        className={`
                          ${prisoner.status === "Incarcerated" ? "bg-blue-50 text-blue-700 border-blue-200" : ""}
                          ${prisoner.status === "Released" ? "bg-green-50 text-green-700 border-green-200" : ""}
                          ${prisoner.status === "Transferred" ? "bg-yellow-50 text-yellow-700 border-yellow-200" : ""}
                          ${prisoner.status === "Paroled" ? "bg-purple-50 text-purple-700 border-purple-200" : ""}
                        `}
                      >
                        {prisoner.status}
                      </Badge>
                    </TableCell>
                    <TableCell>
                      <Badge
                        variant="outline"
                        className={`
                          ${prisoner.securityLevel === "Low" ? "bg-green-50 text-green-700 border-green-200" : ""}
                          ${prisoner.securityLevel === "Medium" ? "bg-yellow-50 text-yellow-700 border-yellow-200" : ""}
                          ${prisoner.securityLevel === "High" ? "bg-orange-50 text-orange-700 border-orange-200" : ""}
                          ${prisoner.securityLevel === "Maximum" ? "bg-red-50 text-red-700 border-red-200" : ""}
                        `}
                      >
                        {prisoner.securityLevel}
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
                ))
              ) : (
                <TableRow>
                  <TableCell
                    colSpan={10}
                    className="text-center py-8 text-gray-500"
                  >
                    No prisoners found matching your filters
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

export default PrisonersList;
