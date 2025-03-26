import React, { ReactNode } from "react";
import Sidebar from "./Sidebar";
import MainContent from "./MainContent";

interface LayoutProps {
  children: ReactNode;
  title?: string;
  icon?: React.ReactNode;
}

const Layout: React.FC<LayoutProps> = ({
  children,
  title = "Dashboard",
  icon,
}) => {
  return (
    <div className="layout">
      <Sidebar />
      <MainContent title={title} icon={icon}>
        {children}
      </MainContent>
    </div>
  );
};

export default Layout;
