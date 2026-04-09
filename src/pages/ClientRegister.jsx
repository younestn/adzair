import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { useToast } from '../context/ToastContext';

export default function ClientRegister() {
  const { register } = useAuth();
  const { pushToast } = useToast();
  const navigate = useNavigate();
  const [form, setForm] = useState({ fullName: '', email: '', phone: '', password: '', city: '', businessName: '', businessType: '' });

  const submit = (e) => {
    e.preventDefault();
    if (Object.values(form).some((v) => !v.trim())) return pushToast('يرجى تعبئة جميع الحقول.', 'error');
    if (form.password.length < 8) return pushToast('كلمة المرور يجب أن تكون 8 أحرف على الأقل.', 'error');
    try {
      register({ ...form, role: 'client' });
      pushToast('تم إنشاء الحساب بنجاح.');
      navigate('/client/dashboard');
    } catch (err) {
      pushToast(err.message, 'error');
    }
  };

  return (
    <div className="mx-auto max-w-2xl p-4 py-10">
      <form onSubmit={submit} className="card space-y-4">
        <h1 className="text-2xl font-extrabold">تسجيل العميل</h1>
        {[
          ['fullName', 'الاسم الكامل', 'مثال: خالد الشمري'],
          ['email', 'البريد الإلكتروني', 'example@company.com'],
          ['phone', 'رقم الهاتف', '05XXXXXXXX'],
          ['password', 'كلمة المرور', '********'],
          ['city', 'المدينة', 'الرياض'],
          ['businessName', 'اسم النشاط', 'متجر العطور'],
          ['businessType', 'نوع النشاط', 'تجارة إلكترونية'],
        ].map(([key, label, ph]) => (
          <div key={key}><label className="text-sm font-bold">{label}</label><input type={key === 'password' ? 'password' : 'text'} className="input" placeholder={ph} onChange={(e) => setForm({ ...form, [key]: e.target.value })} /></div>
        ))}
        <button className="btn-primary w-full">إنشاء حساب العميل</button>
        <p className="text-center text-sm">لديك حساب؟ <Link className="font-bold text-brand-700" to="/client/login">سجّل الدخول</Link></p>
      </form>
    </div>
  );
}
