import { Suspense, lazy } from "react";
import { useRoutes, Routes, Route } from "react-router-dom";
import Home from "./components/home";
import routes from "tempo-routes";

// Lazy load pages for better performance
const Login = lazy(() => import("./pages/login"));
const VisitorsLog = lazy(() => import("./pages/visitors-log"));
const AddVisitor = lazy(() => import("./pages/add-visitor"));
const PrisonersList = lazy(() => import("./pages/prisoners-list"));
const AddPrisoner = lazy(() => import("./pages/add-prisoner"));
const PrisonerProfile = lazy(() => import("./pages/prisoner-profile"));

function App() {
  return (
    <Suspense
      fallback={
        <div className="flex h-screen w-full items-center justify-center">
          Loading...
        </div>
      }
    >
      <>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/login" element={<Login />} />
          <Route path="/visitors-log" element={<VisitorsLog />} />
          <Route path="/add-visitor" element={<AddVisitor />} />
          <Route path="/prisoners-list" element={<PrisonersList />} />
          <Route path="/add-prisoner" element={<AddPrisoner />} />
          <Route path="/prisoner-profile" element={<PrisonerProfile />} />

          {/* Add a catch-all route that redirects to home */}
          {import.meta.env.VITE_TEMPO === "true" && (
            <Route path="/tempobook/*" />
          )}
          <Route path="*" element={<Home />} />
        </Routes>
        {import.meta.env.VITE_TEMPO === "true" && useRoutes(routes)}
      </>
    </Suspense>
  );
}

export default App;
