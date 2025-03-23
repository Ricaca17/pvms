import React, { useState } from "react";
import Layout from "../components/Layout";
import { Button } from "../components/ui/button";
import { Input } from "../components/ui/input";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "../components/ui/card";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "../components/ui/select";
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "../components/ui/tabs";
import { UserPlus, Save, X } from "lucide-react";

const AddVisitor = () => {
  const [formData, setFormData] = useState({
    firstName: "",
    lastName: "",
    idType: "national",
    idNumber: "",
    relationship: "family",
    phone: "",
    email: "",
    address: "",
    prisonerToVisit: "",
    visitPurpose: "family",
    visitDate: "",
    visitTime: "",
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleSelectChange = (name: string, value: string) => {
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // In a real app, you would submit the form data to your backend
    console.log("Form submitted:", formData);
    alert("Visitor added successfully!");
    // Reset form or redirect
  };

  // Mock data for prisoners
  const prisoners = [
    { id: "P001", name: "Juan Dela Cruz" },
    { id: "P002", name: "Wilson Dizon" },
    { id: "P003", name: "Roberto Mendoza" },
    { id: "P004", name: "Carlos Reyes" },
    { id: "P005", name: "Eduardo Santos" },
    { id: "P006", name: "Fernando Lopez" },
    { id: "P007", name: "Gabriel Torres" },
  ];

  return (
    <Layout title="Add New Visitor">
      <div className="max-w-4xl mx-auto">
        <Tabs defaultValue="visitor-info" className="w-full">
          <TabsList className="grid w-full grid-cols-2">
            <TabsTrigger value="visitor-info">Visitor Information</TabsTrigger>
            <TabsTrigger value="visit-details">Visit Details</TabsTrigger>
          </TabsList>

          <Card className="mt-6 border-t-0 rounded-tl-none rounded-tr-none">
            <form onSubmit={handleSubmit}>
              <TabsContent value="visitor-info" className="space-y-6 p-6">
                <CardHeader className="p-0 pb-6">
                  <CardTitle>Personal Information</CardTitle>
                </CardHeader>
                <CardContent className="p-0 space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label
                        htmlFor="firstName"
                        className="text-sm font-medium"
                      >
                        First Name *
                      </label>
                      <Input
                        id="firstName"
                        name="firstName"
                        value={formData.firstName}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    <div className="space-y-2">
                      <label htmlFor="lastName" className="text-sm font-medium">
                        Last Name *
                      </label>
                      <Input
                        id="lastName"
                        name="lastName"
                        value={formData.lastName}
                        onChange={handleChange}
                        required
                      />
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label htmlFor="idType" className="text-sm font-medium">
                        ID Type *
                      </label>
                      <Select
                        value={formData.idType}
                        onValueChange={(value) =>
                          handleSelectChange("idType", value)
                        }
                      >
                        <SelectTrigger>
                          <SelectValue placeholder="Select ID Type" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="national">National ID</SelectItem>
                          <SelectItem value="drivers">
                            Driver's License
                          </SelectItem>
                          <SelectItem value="passport">Passport</SelectItem>
                          <SelectItem value="other">Other</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <label htmlFor="idNumber" className="text-sm font-medium">
                        ID Number *
                      </label>
                      <Input
                        id="idNumber"
                        name="idNumber"
                        value={formData.idNumber}
                        onChange={handleChange}
                        required
                      />
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label
                        htmlFor="relationship"
                        className="text-sm font-medium"
                      >
                        Relationship to Prisoner *
                      </label>
                      <Select
                        value={formData.relationship}
                        onValueChange={(value) =>
                          handleSelectChange("relationship", value)
                        }
                      >
                        <SelectTrigger>
                          <SelectValue placeholder="Select Relationship" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="family">Family</SelectItem>
                          <SelectItem value="spouse">Spouse</SelectItem>
                          <SelectItem value="legal">
                            Legal Representative
                          </SelectItem>
                          <SelectItem value="friend">Friend</SelectItem>
                          <SelectItem value="other">Other</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <label htmlFor="phone" className="text-sm font-medium">
                        Phone Number *
                      </label>
                      <Input
                        id="phone"
                        name="phone"
                        value={formData.phone}
                        onChange={handleChange}
                        required
                      />
                    </div>
                  </div>

                  <div className="space-y-2">
                    <label htmlFor="email" className="text-sm font-medium">
                      Email Address
                    </label>
                    <Input
                      id="email"
                      name="email"
                      type="email"
                      value={formData.email}
                      onChange={handleChange}
                    />
                  </div>

                  <div className="space-y-2">
                    <label htmlFor="address" className="text-sm font-medium">
                      Address
                    </label>
                    <Input
                      id="address"
                      name="address"
                      value={formData.address}
                      onChange={handleChange}
                    />
                  </div>

                  <div className="flex justify-end space-x-2">
                    <Button type="button" variant="outline">
                      <X className="h-4 w-4 mr-2" />
                      Cancel
                    </Button>
                    <Button
                      type="button"
                      onClick={() =>
                        document
                          .querySelector('[data-value="visit-details"]')
                          ?.click()
                      }
                    >
                      Next
                    </Button>
                  </div>
                </CardContent>
              </TabsContent>

              <TabsContent value="visit-details" className="space-y-6 p-6">
                <CardHeader className="p-0 pb-6">
                  <CardTitle>Visit Information</CardTitle>
                </CardHeader>
                <CardContent className="p-0 space-y-6">
                  <div className="space-y-2">
                    <label
                      htmlFor="prisonerToVisit"
                      className="text-sm font-medium"
                    >
                      Prisoner to Visit *
                    </label>
                    <Select
                      value={formData.prisonerToVisit}
                      onValueChange={(value) =>
                        handleSelectChange("prisonerToVisit", value)
                      }
                    >
                      <SelectTrigger>
                        <SelectValue placeholder="Select Prisoner" />
                      </SelectTrigger>
                      <SelectContent>
                        {prisoners.map((prisoner) => (
                          <SelectItem key={prisoner.id} value={prisoner.id}>
                            {prisoner.name}
                          </SelectItem>
                        ))}
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="space-y-2">
                    <label
                      htmlFor="visitPurpose"
                      className="text-sm font-medium"
                    >
                      Visit Purpose *
                    </label>
                    <Select
                      value={formData.visitPurpose}
                      onValueChange={(value) =>
                        handleSelectChange("visitPurpose", value)
                      }
                    >
                      <SelectTrigger>
                        <SelectValue placeholder="Select Purpose" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="family">Family Visit</SelectItem>
                        <SelectItem value="legal">
                          Legal Consultation
                        </SelectItem>
                        <SelectItem value="social">Social Visit</SelectItem>
                        <SelectItem value="other">Other</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label
                        htmlFor="visitDate"
                        className="text-sm font-medium"
                      >
                        Visit Date *
                      </label>
                      <Input
                        id="visitDate"
                        name="visitDate"
                        type="date"
                        value={formData.visitDate}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    <div className="space-y-2">
                      <label
                        htmlFor="visitTime"
                        className="text-sm font-medium"
                      >
                        Visit Time *
                      </label>
                      <Input
                        id="visitTime"
                        name="visitTime"
                        type="time"
                        value={formData.visitTime}
                        onChange={handleChange}
                        required
                      />
                    </div>
                  </div>

                  <div className="flex justify-end space-x-2 pt-4">
                    <Button
                      type="button"
                      variant="outline"
                      onClick={() =>
                        document
                          .querySelector('[data-value="visitor-info"]')
                          ?.click()
                      }
                    >
                      Previous
                    </Button>
                    <Button
                      type="submit"
                      className="bg-blue-600 hover:bg-blue-700"
                    >
                      <Save className="h-4 w-4 mr-2" />
                      Save Visitor
                    </Button>
                  </div>
                </CardContent>
              </TabsContent>
            </form>
          </Card>
        </Tabs>
      </div>
    </Layout>
  );
};

export default AddVisitor;
