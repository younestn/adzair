import { Navigate, Route, Routes } from 'react-router-dom';
import { useEffect, useState } from 'react';
import Loader from './components/Loader';
import { AuthProvider, useAuth } from './context/AuthContext';
import { ToastProvider } from './context/ToastContext';
import LandingPage from './pages/LandingPage';
import ClientRegister from './pages/ClientRegister';
import ClientLogin from './pages/ClientLogin';
import ClientDashboard from './pages/ClientDashboard';
import CreateCampaign from './pages/CreateCampaign';
import PublisherRegister from './pages/PublisherRegister';
import PublisherLogin from './pages/PublisherLogin';
import PublisherDashboard from './pages/PublisherDashboard';
import PublisherProfile from './pages/PublisherProfile';
import CampaignDetails from './pages/CampaignDetails';
import NotFound from './pages/NotFound';
import { initializeStore } from './utils/storage';

function Protected({ role, children }) {
  const { user } = useAuth();
  if (!user) return <Navigate to={role === 'client' ? '/client/login' : '/publisher/login'} replace />;
  if (user.role !== role) return <Navigate to="/" replace />;
  return children;
}

function AppRoutes() {
  return (
    <Routes>
      <Route path="/" element={<LandingPage />} />
      <Route path="/client/register" element={<ClientRegister />} />
      <Route path="/client/login" element={<ClientLogin />} />
      <Route path="/publisher/register" element={<PublisherRegister />} />
      <Route path="/publisher/login" element={<PublisherLogin />} />
      <Route path="/client/dashboard" element={<Protected role="client"><ClientDashboard /></Protected>} />
      <Route path="/client/campaigns/create" element={<Protected role="client"><CreateCampaign /></Protected>} />
      <Route path="/publisher/dashboard" element={<Protected role="publisher"><PublisherDashboard /></Protected>} />
      <Route path="/publisher/profile" element={<Protected role="publisher"><PublisherProfile /></Protected>} />
      <Route path="/campaigns/:id" element={<CampaignDetails />} />
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
}

export default function App() {
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    initializeStore();
    const t = setTimeout(() => setLoading(false), 700);
    return () => clearTimeout(t);
  }, []);

  if (loading) return <Loader />;

  return (
    <AuthProvider>
      <ToastProvider>
        <AppRoutes />
      </ToastProvider>
    </AuthProvider>
  );
}
