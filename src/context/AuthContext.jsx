import { createContext, useContext, useMemo, useState } from 'react';
import { clearSession, getCurrentUser, loginUser, registerUser, setSession } from '../utils/storage';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(getCurrentUser());

  const login = ({ email, password, role }) => {
    const logged = loginUser({ email, password, role });
    setUser(logged);
  };

  const register = (payload) => {
    const created = registerUser(payload);
    setSession({ userId: created.id, role: created.role });
    setUser(created);
  };

  const logout = () => {
    clearSession();
    setUser(null);
  };

  const value = useMemo(() => ({ user, login, register, logout, setUser }), [user]);

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export const useAuth = () => useContext(AuthContext);
