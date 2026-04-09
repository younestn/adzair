import { Link } from 'react-router-dom';

export default function NotFound() {
  return (
    <div className="flex min-h-screen flex-col items-center justify-center p-4 text-center">
      <p className="text-7xl font-extrabold text-brand-200">404</p>
      <h1 className="mt-2 text-2xl font-bold">الصفحة غير موجودة</h1>
      <p className="mt-2 text-slate-500">ربما تم تغيير الرابط أو حذفه.</p>
      <Link to="/" className="btn-primary mt-5">العودة للرئيسية</Link>
    </div>
  );
}
