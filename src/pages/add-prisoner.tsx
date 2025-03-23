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
import { UserPlus2, Save, X } from "lucide-react";

const AddPrisoner = () => {
  const [formData, setFormData] = useState({
    firstName: "",
    lastName: "",
    age: "",
    gender: "male",
    idNumber: "",
    crime: "",
    sentence: "",
    admissionDate: "",
    releaseDate: "",
    cell: "",
    securityLevel: "medium",
    healthStatus: "good",
    emergencyContactName: "",
    emergencyContactRelation: "",
    emergencyContactPhone: "",
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
    alert("Prisoner added successfully!");
    // Reset form or redirect
  };

  return (
    <Layout title="Add New Prisoner">
      <div className="max-w-4xl mx-auto">
        <Tabs defaultValue="personal-info" className="w-full">
          <TabsList className="grid w-full grid-cols-3">
            <TabsTrigger value="personal-info">
              Personal Information
            </TabsTrigger>
            <TabsTrigger value="incarceration-details">
              Incarceration Details
            </TabsTrigger>
            <TabsTrigger value="health-emergency">
              Health & Emergency
            </TabsTrigger>
          </TabsList>

          <Card className="mt-6 border-t-0 rounded-tl-none rounded-tr-none">
            <form onSubmit={handleSubmit}>
              <TabsContent value="personal-info" className="space-y-6 p-6">
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
                      <label htmlFor="age" className="text-sm font-medium">
                        Age *
                      </label>
                      <Input
                        id="age"
                        name="age"
                        type="number"
                        value={formData.age}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    <div className="space-y-2">
                      <label htmlFor="gender" className="text-sm font-medium">
                        Gender *
                      </label>
                      <Select
                        value={formData.gender}
                        onValueChange={(value) =>
                          handleSelectChange("gender", value)
                        }
                      >
                        <SelectTrigger>
                          <SelectValue placeholder="Select Gender" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="male">Male</SelectItem>
                          <SelectItem value="female">Female</SelectItem>
                          <SelectItem value="other">Other</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
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

                  <div className="flex justify-end space-x-2">
                    <Button type="button" variant="outline">
                      <X className="h-4 w-4 mr-2" />
                      Cancel
                    </Button>
                    <Button
                      type="button"
                      onClick={() =>
                        document
                          .querySelector('[data-value="incarceration-details"]')
                          ?.click()
                      }
                    >
                      Next
                    </Button>
                  </div>
                </CardContent>
              </TabsContent>

              <TabsContent
                value="incarceration-details"
                className="space-y-6 p-6"
              >
                <CardHeader className="p-0 pb-6">
                  <CardTitle>Incarceration Details</CardTitle>
                </CardHeader>
                <CardContent className="p-0 space-y-6">
                  <div className="space-y-2">
                    <label htmlFor="crime" className="text-sm font-medium">
                      Crime/Offense *
                    </label>
                    <Input
                      id="crime"
                      name="crime"
                      value={formData.crime}
                      onChange={handleChange}
                      required
                    />
                  </div>

                  <div className="space-y-2">
                    <label htmlFor="sentence" className="text-sm font-medium">
                      Sentence *
                    </label>
                    <Input
                      id="sentence"
                      name="sentence"
                      placeholder="e.g. 5 years"
                      value={formData.sentence}
                      onChange={handleChange}
                      required
                    />
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label
                        htmlFor="admissionDate"
                        className="text-sm font-medium"
                      >
                        Admission Date *
                      </label>
                      <Input
                        id="admissionDate"
                        name="admissionDate"
                        type="date"
                        value={formData.admissionDate}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    <div className="space-y-2">
                      <label
                        htmlFor="releaseDate"
                        className="text-sm font-medium"
                      >
                        Expected Release Date *
                      </label>
                      <Input
                        id="releaseDate"
                        name="releaseDate"
                        type="date"
                        value={formData.releaseDate}
                        onChange={handleChange}
                        required
                      />
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label htmlFor="cell" className="text-sm font-medium">
                        Cell Assignment *
                      </label>
                      <Input
                        id="cell"
                        name="cell"
                        placeholder="e.g. Block A-101"
                        value={formData.cell}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    <div className="space-y-2">
                      <label
                        htmlFor="securityLevel"
                        className="text-sm font-medium"
                      >
                        Security Level *
                      </label>
                      <Select
                        value={formData.securityLevel}
                        onValueChange={(value) =>
                          handleSelectChange("securityLevel", value)
                        }
                      >
                        <SelectTrigger>
                          <SelectValue placeholder="Select Security Level" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="low">Low</SelectItem>
                          <SelectItem value="medium">Medium</SelectItem>
                          <SelectItem value="high">High</SelectItem>
                          <SelectItem value="maximum">Maximum</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="flex justify-end space-x-2">
                    <Button
                      type="button"
                      variant="outline"
                      onClick={() =>
                        document
                          .querySelector('[data-value="personal-info"]')
                          ?.click()
                      }
                    >
                      Previous
                    </Button>
                    <Button
                      type="button"
                      onClick={() =>
                        document
                          .querySelector('[data-value="health-emergency"]')
                          ?.click()
                      }
                    >
                      Next
                    </Button>
                  </div>
                </CardContent>
              </TabsContent>

              <TabsContent value="health-emergency" className="space-y-6 p-6">
                <CardHeader className="p-0 pb-6">
                  <CardTitle>Health & Emergency Contact</CardTitle>
                </CardHeader>
                <CardContent className="p-0 space-y-6">
                  <div className="space-y-2">
                    <label
                      htmlFor="healthStatus"
                      className="text-sm font-medium"
                    >
                      Health Status *
                    </label>
                    <Select
                      value={formData.healthStatus}
                      onValueChange={(value) =>
                        handleSelectChange("healthStatus", value)
                      }
                    >
                      <SelectTrigger>
                        <SelectValue placeholder="Select Health Status" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="good">Good</SelectItem>
                        <SelectItem value="fair">Fair</SelectItem>
                        <SelectItem value="poor">Poor</SelectItem>
                        <SelectItem value="critical">Critical</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="space-y-2">
                    <label
                      htmlFor="emergencyContactName"
                      className="text-sm font-medium"
                    >
                      Emergency Contact Name *
                    </label>
                    <Input
                      id="emergencyContactName"
                      name="emergencyContactName"
                      value={formData.emergencyContactName}
                      onChange={handleChange}
                      required
                    />
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label
                        htmlFor="emergencyContactRelation"
                        className="text-sm font-medium"
                      >
                        Relationship *
                      </label>
                      <Input
                        id="emergencyContactRelation"
                        name="emergencyContactRelation"
                        placeholder="e.g. Spouse, Parent"
                        value={formData.emergencyContactRelation}
                        onChange={handleChange}
                        required
                      />
                    </div>
                    <div className="space-y-2">
                      <label
                        htmlFor="emergencyContactPhone"
                        className="text-sm font-medium"
                      >
                        Phone Number *
                      </label>
                      <Input
                        id="emergencyContactPhone"
                        name="emergencyContactPhone"
                        value={formData.emergencyContactPhone}
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
                          .querySelector('[data-value="incarceration-details"]')
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
                      Save Prisoner
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

export default AddPrisoner;
