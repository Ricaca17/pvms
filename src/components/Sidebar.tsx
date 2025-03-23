import React, { useState } from "react";
import { Link } from "react-router-dom";
import {
  Home,
  Clock,
  UserPlus,
  Users,
  UserPlus2,
  User,
  LogOut,
  Moon,
  Sun,
} from "lucide-react";
import { cn } from "../lib/utils";

interface SidebarProps {
  className?: string;
  isDarkMode?: boolean;
  toggleDarkMode?: () => void;
}

const Sidebar = ({
  className = "",
  isDarkMode = false,
  toggleDarkMode = () => {},
}: SidebarProps) => {
  const [activeLink, setActiveLink] = useState<string>("dashboard");

  const handleLinkClick = (link: string) => {
    setActiveLink(link);
  };

  return (
    <div
      className={cn(
        "w-[280px] h-full bg-[#222] text-white flex flex-col",
        className,
      )}
    >
      {/* Logo and Title */}
      <div className="p-6 flex items-center gap-3">
        <div className="w-8 h-8 bg-white rounded-full overflow-hidden">
          <img
            src="https://api.dicebear.com/7.x/avataaars/svg?seed=prison"
            alt="PVMS Logo"
            className="w-full h-full object-cover"
          />
        </div>
        <h1 className="text-2xl font-bold">PVMS</h1>
      </div>

      {/* User Info */}
      <div className="px-6 py-3 border-b border-gray-700">
        <p className="text-sm text-gray-400">Logged in as:</p>
        <p className="font-medium">admin123</p>
      </div>

      {/* Navigation Links */}
      <nav className="flex-1 py-6">
        <ul className="space-y-1">
          <li>
            <Link
              to="/"
              className={cn(
                "flex items-center gap-3 px-6 py-3 hover:bg-blue-600 transition-colors",
                activeLink === "dashboard" && "bg-blue-700",
              )}
              onClick={() => handleLinkClick("dashboard")}
            >
              <Home size={20} />
              <span>Dashboard</span>
            </Link>
          </li>
          <li>
            <Link
              to="/visitors-log"
              className={cn(
                "flex items-center gap-3 px-6 py-3 hover:bg-blue-600 transition-colors",
                activeLink === "visitors-log" && "bg-blue-700",
              )}
              onClick={() => handleLinkClick("visitors-log")}
            >
              <Clock size={20} />
              <span>Visitors Log</span>
            </Link>
          </li>
          <li>
            <Link
              to="/add-visitor"
              className={cn(
                "flex items-center gap-3 px-6 py-3 hover:bg-blue-600 transition-colors",
                activeLink === "add-visitor" && "bg-blue-700",
              )}
              onClick={() => handleLinkClick("add-visitor")}
            >
              <UserPlus size={20} />
              <span>Add New Visitor</span>
            </Link>
          </li>
          <li>
            <Link
              to="/prisoners-list"
              className={cn(
                "flex items-center gap-3 px-6 py-3 hover:bg-blue-600 transition-colors",
                activeLink === "prisoners-list" && "bg-blue-700",
              )}
              onClick={() => handleLinkClick("prisoners-list")}
            >
              <Users size={20} />
              <span>Prisoners List</span>
            </Link>
          </li>
          <li>
            <Link
              to="/add-prisoner"
              className={cn(
                "flex items-center gap-3 px-6 py-3 hover:bg-blue-600 transition-colors",
                activeLink === "add-prisoner" && "bg-blue-700",
              )}
              onClick={() => handleLinkClick("add-prisoner")}
            >
              <UserPlus2 size={20} />
              <span>Add New Prisoner</span>
            </Link>
          </li>
          <li>
            <Link
              to="/prisoner-profile"
              className={cn(
                "flex items-center gap-3 px-6 py-3 hover:bg-blue-600 transition-colors",
                activeLink === "prisoner-profile" && "bg-blue-700",
              )}
              onClick={() => handleLinkClick("prisoner-profile")}
            >
              <User size={20} />
              <span>Prisoner Profile</span>
            </Link>
          </li>
        </ul>
      </nav>

      {/* Footer Actions */}
      <div className="mt-auto border-t border-gray-700">
        <Link
          to="/login"
          className="flex items-center gap-3 px-6 py-4 hover:bg-red-700 transition-colors"
        >
          <LogOut size={20} />
          <span>Logout</span>
        </Link>
        <button
          onClick={toggleDarkMode}
          className="w-full flex items-center justify-between px-6 py-4 hover:bg-gray-700 transition-colors"
        >
          <div className="flex items-center gap-3">
            {isDarkMode ? <Sun size={20} /> : <Moon size={20} />}
            <span>Dark Mode</span>
          </div>
          <div
            className={cn(
              "w-10 h-5 rounded-full relative transition-colors",
              isDarkMode ? "bg-blue-600" : "bg-gray-600",
            )}
          >
            <div
              className={cn(
                "absolute top-0.5 w-4 h-4 rounded-full bg-white transition-transform",
                isDarkMode ? "translate-x-5" : "translate-x-0.5",
              )}
            ></div>
          </div>
        </button>
      </div>
    </div>
  );
};

export default Sidebar;
