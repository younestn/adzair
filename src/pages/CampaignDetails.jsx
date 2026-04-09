import { Link, useParams } from 'react-router-dom';
import StatusBadge from '../components/StatusBadge';
import { formatDate } from '../utils/helpers';
import { getCampaigns } from '../utils/storage';

export default function CampaignDetails() {
  const { id } = useParams();
  const campaign = getCampaigns().find((c) => c.id === id);
  if (!campaign) return <div className="p-8">الحملة غير موجودة.</div>;

  return (
    <div className="mx-auto max-w-5xl p-4 py-8">
      <div className="mb-4"><Link to="/" className="text-sm font-bold text-brand-700">← العودة</Link></div>
      <div className="card">
        {campaign.image && <img src={campaign.image} className="mb-5 h-72 w-full rounded-2xl object-cover" />}
        <div className="mb-3 flex items-center justify-between"><h1 className="text-2xl font-extrabold">{campaign.title}</h1><StatusBadge status={campaign.status} /></div>
        <p className="mb-4 text-slate-700">{campaign.postText}</p>
        <div className="grid gap-3 md:grid-cols-2 text-sm">
          <p><b>رابط المنشور:</b> {campaign.postUrl}</p>
          <p><b>رابط الصفحة:</b> {campaign.pageUrl}</p>
          <p><b>مكان النشر:</b> {campaign.placement}</p>
          <p><b>نوع المحتوى:</b> {campaign.contentType}</p>
          <p><b>الفئة المستهدفة:</b> {campaign.audience}</p>
          <p><b>اسم العميل:</b> {campaign.clientName}</p>
        </div>
        <h3 className="mt-6 mb-2 font-bold">Timeline الحملة</h3>
        <div className="space-y-2 border-r-2 border-brand-100 pr-4">
          {(campaign.timeline || []).map((t, i) => <div key={i} className="text-sm"><p className="font-semibold">{t.label}</p><p className="text-slate-500">{formatDate(t.at)}</p></div>)}
        </div>
      </div>
    </div>
  );
}
