import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import DashboardLayout from '../layouts/DashboardLayout';
import { useAuth } from '../context/AuthContext';
import { useToast } from '../context/ToastContext';
import { readFileAsDataURL } from '../utils/helpers';
import { saveCampaign } from '../utils/storage';

export default function CreateCampaign() {
  const { user } = useAuth();
  const { pushToast } = useToast();
  const navigate = useNavigate();
  const [form, setForm] = useState({ title: '', image: '', postText: '', postUrl: '', pageUrl: '', placement: '', contentType: '', audience: '', notes: '' });

  const submit = (e) => {
    e.preventDefault();
    const required = ['title', 'postText', 'postUrl', 'pageUrl', 'placement', 'contentType', 'audience'];
    if (required.some((k) => !form[k]?.trim())) return pushToast('الرجاء تعبئة الحقول المطلوبة.', 'error');
    saveCampaign({ ...form, clientId: user.id, clientName: user.fullName });
    pushToast('تم إرسال الحملة للمراجعة بنجاح.');
    navigate('/client/dashboard');
  };

  return (
    <DashboardLayout title="إنشاء حملة جديدة" subtitle="أدخل تفاصيل الحملة وأرسلها مباشرة للناشرين" links={[{ to: '/client/dashboard', label: 'لوحة العميل', icon: 'home' }, { to: '/client/campaigns/create', label: 'إنشاء حملة', icon: 'plus' }]}>
      <form onSubmit={submit} className="card grid gap-4 md:grid-cols-2">
        {[
          ['title', 'عنوان الحملة'], ['postUrl', 'رابط المنشور'], ['pageUrl', 'رابط الصفحة'], ['placement', 'مكان النشر المطلوب'], ['contentType', 'نوع المحتوى'], ['audience', 'الفئة المستهدفة'],
        ].map(([k, l]) => (
          <div key={k}><label className="text-sm font-bold">{l}</label><input className="input" onChange={(e) => setForm({ ...form, [k]: e.target.value })} /></div>
        ))}
        <div className="md:col-span-2"><label className="text-sm font-bold">نص المنشور</label><textarea className="input" rows={4} onChange={(e) => setForm({ ...form, postText: e.target.value })} /></div>
        <div className="md:col-span-2"><label className="text-sm font-bold">ملاحظات إضافية</label><textarea className="input" rows={3} onChange={(e) => setForm({ ...form, notes: e.target.value })} /></div>
        <div className="md:col-span-2"><label className="text-sm font-bold">صورة المنشور</label><input type="file" accept="image/*" className="input" onChange={async (e) => e.target.files[0] && setForm({ ...form, image: await readFileAsDataURL(e.target.files[0]) })} />{form.image && <img src={form.image} className="mt-2 h-40 w-full rounded-xl object-cover" />}</div>
        <button className="btn-primary md:col-span-2">إرسال للمراجعة</button>
      </form>
    </DashboardLayout>
  );
}
