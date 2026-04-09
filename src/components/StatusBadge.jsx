const statusMap = {
  draft: 'bg-slate-100 text-slate-700',
  pending: 'bg-amber-100 text-amber-700',
  accepted: 'bg-emerald-100 text-emerald-700',
  rejected: 'bg-rose-100 text-rose-700',
};

const statusLabel = {
  draft: 'مسودة',
  pending: 'قيد المراجعة',
  accepted: 'مقبولة',
  rejected: 'مرفوضة',
};

export default function StatusBadge({ status }) {
  return (
    <span className={`rounded-full px-3 py-1 text-xs font-bold ${statusMap[status] || statusMap.draft}`}>
      {statusLabel[status] || 'مسودة'}
    </span>
  );
}
