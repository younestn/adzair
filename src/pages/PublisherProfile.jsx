import { useState } from 'react';
import DashboardLayout from '../layouts/DashboardLayout';
import { useAuth } from '../context/AuthContext';
import { useToast } from '../context/ToastContext';
import { readFileAsDataURL } from '../utils/helpers';
import { updateUserProfile } from '../utils/storage';

export default function PublisherProfile() {
  const { user, setUser } = useAuth();
  const { pushToast } = useToast();
  const [form, setForm] = useState({
    fullName: user.fullName || '', city: user.city || '', specialization: user.specialization || '', facebookUrl: user.facebookUrl || '', bio: user.bio || '', followers: user.followers || '', avatar: user.avatar || '',
  });

  const save = (e) => {
    e.preventDefault();
    const updated = updateUserProfile(user.id, form);
    setUser(updated);
    pushToast('تم حفظ بيانات الملف الشخصي.');
  };

  return (
    <DashboardLayout title="الملف الشخصي للناشر" subtitle="قم بتحديث بياناتك لزيادة فرص قبول الحملات" links={[{ to: '/publisher/dashboard', label: 'لوحة الناشر', icon: 'home' }, { to: '/publisher/profile', label: 'الملف الشخصي', icon: 'user' }]}> 
      <form onSubmit={save} className="card grid gap-4 md:grid-cols-2">
        {['fullName', 'city', 'specialization', 'facebookUrl', 'followers'].map((k) => <div key={k}><label className="text-sm font-bold">{k}</label><input className="input" value={form[k]} onChange={(e) => setForm({ ...form, [k]: e.target.value })} /></div>)}
        <div className="md:col-span-2"><label className="text-sm font-bold">النبذة</label><textarea className="input" rows={4} value={form.bio} onChange={(e) => setForm({ ...form, bio: e.target.value })} /></div>
        <div className="md:col-span-2"><label className="text-sm font-bold">الصورة</label><input type="file" className="input" accept="image/*" onChange={async (e) => e.target.files[0] && setForm({ ...form, avatar: await readFileAsDataURL(e.target.files[0]) })} />{form.avatar && <img src={form.avatar} className="mt-2 h-20 w-20 rounded-xl object-cover" />}</div>
        <button className="btn-primary md:col-span-2">حفظ التعديلات</button>
      </form>
    </DashboardLayout>
  );
}
