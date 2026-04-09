import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { useToast } from '../context/ToastContext';

export default function PublisherLogin() {
  const { login } = useAuth();
  const { pushToast } = useToast();
  const navigate = useNavigate();
  const [email, setEmail] = useState('publisher@adzair.demo');
  const [password, setPassword] = useState('12345678');

  const submit = (e) => {
    e.preventDefault();
    try {
      login({ email, password, role: 'publisher' });
      pushToast('تم تسجيل الدخول بنجاح.');
      navigate('/publisher/dashboard');
    } catch (err) {
      pushToast(err.message, 'error');
    }
  };

  return (
    <div className="mx-auto max-w-md p-4 py-12">
      <form onSubmit={submit} className="card space-y-4">
        <h1 className="text-2xl font-extrabold">تسجيل دخول الناشر</h1>
        <div><label className="text-sm font-bold">البريد</label><input className="input" value={email} onChange={(e) => setEmail(e.target.value)} /></div>
        <div><label className="text-sm font-bold">كلمة المرور</label><input type="password" className="input" value={password} onChange={(e) => setPassword(e.target.value)} /></div>
        <button className="btn-primary w-full">دخول</button>
        <p className="text-center text-sm">لا تملك حساب؟ <Link className="font-bold text-brand-700" to="/publisher/register">إنشاء حساب</Link></p>
      </form>
    </div>
  );
}
