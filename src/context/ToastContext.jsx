import { createContext, useContext, useState } from 'react';

const ToastContext = createContext(null);

export function ToastProvider({ children }) {
  const [toasts, setToasts] = useState([]);

  const pushToast = (message, type = 'success') => {
    const toast = { id: crypto.randomUUID(), message, type };
    setToasts((prev) => [...prev, toast]);
    setTimeout(() => setToasts((prev) => prev.filter((t) => t.id !== toast.id)), 3000);
  };

  return (
    <ToastContext.Provider value={{ pushToast }}>
      {children}
      <div className="fixed left-4 top-4 z-50 space-y-2">
        {toasts.map((toast) => (
          <div
            key={toast.id}
            className={`rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-lg transition ${
              toast.type === 'error' ? 'bg-rose-500' : 'bg-emerald-500'
            }`}
          >
            {toast.message}
          </div>
        ))}
      </div>
    </ToastContext.Provider>
  );
}

export const useToast = () => useContext(ToastContext);
