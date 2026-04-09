import { BarChart3, CheckCircle2, Clock3, Eye, XCircle } from 'lucide-react';
import { Link } from 'react-router-dom';
import StatusBadge from '../components/StatusBadge';
import StatCard from '../components/StatCard';
import DashboardLayout from '../layouts/DashboardLayout';
import { useToast } from '../context/ToastContext';
import { getCampaigns, markPublisherNotificationsRead, updateCampaignStatus } from '../utils/storage';

export default function PublisherDashboard() {
  const { pushToast } = useToast();
  const campaigns = getCampaigns();
  const newCount = campaigns.filter((c) => c.isNewForPublisher).length;
  const stats = {
    total: campaigns.length,
    pending: campaigns.filter((c) => c.status === 'pending').length,
    accepted: campaigns.filter((c) => c.status === 'accepted').length,
    rejected: campaigns.filter((c) => c.status === 'rejected').length,
  };

  const changeStatus = (id, status) => {
    updateCampaignStatus(id, status);
    pushToast('تم تحديث حالة الإعلان.');
    window.location.reload();
  };

  return (
    <DashboardLayout
      title="لوحة الناشر"
      subtitle="راجع الإعلانات الواردة واتخذ قرارك بسرعة"
      links={[{ to: '/publisher/dashboard', label: 'لوحة الناشر', icon: 'home', showBadge: true }, { to: '/publisher/profile', label: 'الملف الشخصي', icon: 'user' }]}
      badge={newCount}
    >
      <div className="mb-5 card flex items-center justify-between bg-amber-50">
        <p className="font-bold text-amber-800">لديك {newCount} إشعار جديد للحملات الواردة.</p>
        <button className="btn-secondary" onClick={() => { markPublisherNotificationsRead(); window.location.reload(); }}>تعليم الكل كمقروء</button>
      </div>
      <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <StatCard title="الإعلانات الكلية" value={stats.total} icon={BarChart3} />
        <StatCard title="قيد المراجعة" value={stats.pending} icon={Clock3} tone="amber" />
        <StatCard title="مقبولة" value={stats.accepted} icon={CheckCircle2} tone="emerald" />
        <StatCard title="مرفوضة" value={stats.rejected} icon={XCircle} tone="rose" />
      </div>

      <div className="mt-5 grid gap-4 lg:grid-cols-2">
        {campaigns.map((c) => (
          <div key={c.id} className="card">
            {c.image && <img src={c.image} className="mb-3 h-40 w-full rounded-xl object-cover" />}
            <div className="mb-2 flex items-center justify-between"><h3 className="font-bold">{c.title}</h3><StatusBadge status={c.status} /></div>
            <p className="line-clamp-2 text-sm text-slate-600">{c.postText}</p>
            <p className="mt-2 text-xs text-slate-500">العميل: {c.clientName}</p>
            <p className="text-xs text-slate-500">المكان: {c.placement}</p>
            <div className="mt-3 flex flex-wrap gap-2">
              <Link to={`/campaigns/${c.id}`} className="btn-secondary"><Eye size={14} className="inline" /> التفاصيل</Link>
              <button className="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-bold text-white" onClick={() => changeStatus(c.id, 'accepted')}>قبول</button>
              <button className="rounded-xl bg-amber-500 px-3 py-2 text-xs font-bold text-white" onClick={() => changeStatus(c.id, 'pending')}>قيد المراجعة</button>
              <button className="rounded-xl bg-rose-600 px-3 py-2 text-xs font-bold text-white" onClick={() => changeStatus(c.id, 'rejected')}>رفض</button>
            </div>
          </div>
        ))}
      </div>
    </DashboardLayout>
  );
}
