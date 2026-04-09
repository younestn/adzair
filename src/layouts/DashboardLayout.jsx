import { Bell, Home, LogOut, PlusCircle, User } from 'lucide-react';
import { Link, NavLink } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

export default function DashboardLayout({ title, subtitle, links, children, badge }) {
  const { user, logout } = useAuth();

  return (
    <div className="min-h-screen bg-slate-50">
      <div className="mx-auto grid max-w-7xl gap-6 p-4 lg:grid-cols-[260px_1fr]">
        <aside className="rounded-3xl bg-white p-4 shadow-soft ring-1 ring-slate-100">
          <Link to="/" className="mb-8 flex items-center gap-2 text-xl font-extrabold text-brand-700">
            <span className="rounded-xl bg-brand-100 p-2 text-brand-700">AD</span> ADZAIR
          </Link>
          <nav className="space-y-1">
            {links.map((item) => (
              <NavLink
                key={item.to}
                to={item.to}
                className={({ isActive }) =>
                  `flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold transition ${
                    isActive ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-100'
                  }`
                }
              >
                <span className="flex items-center gap-2">
                  {item.icon === 'home' && <Home size={16} />}
                  {item.icon === 'plus' && <PlusCircle size={16} />}
                  {item.icon === 'user' && <User size={16} />}
                  {item.label}
                </span>
                {item.showBadge && badge > 0 && (
                  <span className="rounded-full bg-rose-500 px-2 py-0.5 text-xs text-white">{badge}</span>
                )}
              </NavLink>
            ))}
          </nav>
          <button
            onClick={logout}
            className="mt-8 flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50"
          >
            <LogOut size={16} /> تسجيل الخروج
          </button>
        </aside>

        <main>
          <div className="mb-5 flex items-center justify-between rounded-3xl bg-white p-5 shadow-soft ring-1 ring-slate-100">
            <div>
              <h1 className="text-2xl font-extrabold text-slate-900">{title}</h1>
              <p className="text-sm text-slate-500">{subtitle}</p>
            </div>
            <div className="flex items-center gap-3 text-sm text-slate-500">
              <Bell size={18} className="text-brand-600" />
              <span>{user?.fullName}</span>
            </div>
          </div>
          {children}
        </main>
      </div>
    </div>
  );
}
