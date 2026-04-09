import { Link } from 'react-router-dom';

export default function LandingPage() {
  return (
    <div className="min-h-screen bg-gradient-to-b from-brand-50 to-slate-50 text-slate-800">
      <header className="mx-auto flex max-w-7xl items-center justify-between px-4 py-5">
        <div className="text-2xl font-extrabold text-brand-700">ADZAIR</div>
        <div className="flex gap-2">
          <Link to="/client/login" className="btn-secondary">دخول العميل</Link>
          <Link to="/publisher/login" className="btn-secondary">دخول الناشر</Link>
        </div>
      </header>

      <section className="mx-auto grid max-w-7xl items-center gap-8 px-4 py-14 lg:grid-cols-2">
        <div>
          <p className="mb-3 inline-flex rounded-full bg-brand-100 px-3 py-1 text-xs font-bold text-brand-700">منصة ربط إعلاني ذكية</p>
          <h1 className="mb-4 text-4xl font-extrabold leading-tight text-slate-900">حوّل حملاتك إلى نتائج عبر شبكة ناشرين موثوقين على فيسبوك</h1>
          <p className="mb-7 text-lg text-slate-600">ADZAIR تجمع العميل والناشر في لوحة واحدة لإدارة الطلبات، المراجعة، والمتابعة بشكل احترافي وشفاف.</p>
          <div className="flex flex-wrap gap-3">
            <Link to="/client/register" className="btn-primary">تسجيل كعميل</Link>
            <Link to="/publisher/register" className="btn-secondary">تسجيل كناشر</Link>
          </div>
        </div>
        <div className="card bg-white/90">
          <h3 className="mb-4 text-xl font-bold">كيف تعمل المنصة؟</h3>
          <ol className="space-y-3 text-sm text-slate-600">
            <li>1) العميل ينشئ حملة ويرسلها للمراجعة.</li>
            <li>2) الناشر يستقبل تنبيه مباشر في لوحة التحكم.</li>
            <li>3) يتم قبول/رفض/تعليق الحملة مع تحديث فوري.</li>
          </ol>
        </div>
      </section>

      <section className="mx-auto max-w-7xl px-4 py-10">
        <div className="grid gap-4 md:grid-cols-2">
          <div className="card"><h4 className="mb-2 font-bold">مميزات العميل</h4><p className="text-sm text-slate-600">إنشاء حملات بسرعة، متابعة الحالة لحظيًا، وإدارة كل الطلبات من لوحة واحدة.</p></div>
          <div className="card"><h4 className="mb-2 font-bold">مميزات الناشر</h4><p className="text-sm text-slate-600">تنبيهات للحملات الجديدة، مراجعة شاملة للتفاصيل، وإدارة أعمالك بكفاءة.</p></div>
        </div>
      </section>

      <footer className="mt-10 border-t border-slate-200 py-6 text-center text-sm text-slate-500">© {new Date().getFullYear()} ADZAIR - نموذج أولي احترافي.</footer>
    </div>
  );
}
