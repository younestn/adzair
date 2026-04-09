import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { useToast } from '../context/ToastContext';
import { readFileAsDataURL } from '../utils/helpers';

export default function PublisherRegister() {
  const [form, setForm] = useState({ fullName: '', email: '', phone: '', password: '', city: '', specialization: '', facebookUrl: '', bio: '', followers: '', avatar: '' });
  const { register } = useAuth();
  const { pushToast } = useToast();
  const navigate = useNavigate();

  const submit = (e) => {
    e.preventDefault();
    const required = ['fullName', 'email', 'phone', 'password', 'city', 'specialization', 'facebookUrl', 'bio', 'followers'];
    if (required.some((k) => !form[k]?.trim())) return pushToast('جميع الحقول الأساسية مطلوبة.', 'error');
    try {
      register({ ...form, role: 'publisher' });
      pushToast('تم إنشاء حساب الناشر بنجاح.');
      navigate('/publisher/dashboard');
    } catch (err) {
      pushToast(err.message, 'error');
    }
  };

  return (
    <div className="mx-auto max-w-2xl p-4 py-10">
      <form onSubmit={submit} className="card space-y-4">
        <h1 className="text-2xl font-extrabold">تسجيل الناشر</h1>
        {[
          ['fullName', 'الاسم الكامل'], ['email', 'البريد الإلكتروني'], ['phone', 'رقم الهاتف'], ['password', 'كلمة المرور'], ['city', 'المدينة'],
          ['specialization', 'التخصص'], ['facebookUrl', 'رابط صفحة الفيسبوك'], ['bio', 'نبذة'], ['followers', 'عدد المتابعين التقريبي'],
        ].map(([k, l]) => (
          <div key={k}><label className="text-sm font-bold">{l}</label>{k === 'bio' ? <textarea className="input" onChange={(e) => setForm({ ...form, [k]: e.target.value })} /> : <input type={k === 'password' ? 'password' : 'text'} className="input" onChange={(e) => setForm({ ...form, [k]: e.target.value })} />}</div>
        ))}
        <div>
          <label className="text-sm font-bold">الصورة الشخصية (اختيارية)</label>
          <input type="file" accept="image/*" className="input" onChange={async (e) => e.target.files[0] && setForm({ ...form, avatar: await readFileAsDataURL(e.target.files[0]) })} />
          {form.avatar && <img src={form.avatar} className="mt-2 h-16 w-16 rounded-xl object-cover" />}
        </div>
        <button className="btn-primary w-full">إنشاء حساب الناشر</button>
        <p className="text-center text-sm">لديك حساب؟ <Link className="font-bold text-brand-700" to="/publisher/login">سجّل الدخول</Link></p>
      </form>
    </div>
  );
}
