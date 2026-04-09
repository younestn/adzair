export default function StatCard({ title, value, icon: Icon, tone = 'brand' }) {
  const toneMap = {
    brand: 'bg-brand-50 text-brand-700',
    amber: 'bg-amber-50 text-amber-700',
    emerald: 'bg-emerald-50 text-emerald-700',
    rose: 'bg-rose-50 text-rose-700',
  };

  return (
    <div className="card transition hover:-translate-y-1">
      <div className="mb-4 flex items-center justify-between">
        <p className="text-sm text-slate-500">{title}</p>
        <div className={`rounded-xl p-2 ${toneMap[tone]}`}>
          <Icon size={18} />
        </div>
      </div>
      <p className="text-3xl font-extrabold text-slate-900">{value}</p>
    </div>
  );
}
