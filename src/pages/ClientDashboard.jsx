import { BarChart3, CheckCircle2, Clock3, XCircle } from 'lucide-react';
import { Link } from 'react-router-dom';
import StatusBadge from '../components/StatusBadge';
import StatCard from '../components/StatCard';
import DashboardLayout from '../layouts/DashboardLayout';
import { getCampaigns } from '../utils/storage';
import { useAuth } from '../context/AuthContext';

export default function ClientDashboard() {
  const { user } = useAuth();
  const campaigns = getCampaigns().filter((c) => c.clientId === user.id);
  const stats = {
    total: campaigns.length,
    pending: campaigns.filter((c) => c.status === 'pending').length,
    accepted: campaigns.filter((c) => c.status === 'accepted').length,
    rejected: campaigns.filter((c) => c.status === 'rejected').length,
  };

  return (
    <DashboardLayout title={`أهلاً ${user.fullName}`} subtitle="تابع حملاتك الإعلانية لحظة بلحظة" links={[{ to: '/client/dashboard', label: 'لوحة العميل', icon: 'home' }, { to: '/client/campaigns/create', label: 'إنشاء حملة', icon: 'plus' }]}>
      <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <StatCard title="إجمالي الحملات" value={stats.total} icon={BarChart3} />
        <StatCard title="قيد المراجعة" value={stats.pending} icon={Clock3} tone="amber" />
        <StatCard title="مقبولة" value={stats.accepted} icon={CheckCircle2} tone="emerald" />
        <StatCard title="مرفوضة" value={stats.rejected} icon={XCircle} tone="rose" />
      </div>
      <div className="mt-5 card">
        <div className="mb-4 flex items-center justify-between"><h2 className="text-lg font-extrabold">حملاتك</h2><Link to="/client/campaigns/create" className="btn-primary">إنشاء حملة جديدة</Link></div>
        {campaigns.length === 0 ? <div className="rounded-xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">لا توجد حملات بعد، ابدأ الآن بحملتك الأولى.</div> : (
          <div className="space-y-3">
            {campaigns.map((c) => (
              <Link key={c.id} to={`/campaigns/${c.id}`} className="flex items-center justify-between rounded-xl border border-slate-100 p-4 transition hover:bg-slate-50">
                <div><p className="font-bold text-slate-800">{c.title}</p><p className="text-xs text-slate-500">{c.placement}</p></div>
                <StatusBadge status={c.status} />
              </Link>
            ))}
          </div>
        )}
      </div>
    </DashboardLayout>
  );
}
