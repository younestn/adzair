const KEYS = {
  users: 'adzair_users',
  campaigns: 'adzair_campaigns',
  session: 'adzair_session',
  initialized: 'adzair_initialized',
};

const nowISO = () => new Date().toISOString();

const sampleImage =
  'https://images.unsplash.com/photo-1552581234-26160f608093?auto=format&fit=crop&w=800&q=80';

const seedData = () => {
  if (localStorage.getItem(KEYS.initialized)) return;

  const client = {
    id: 'client-demo-1',
    role: 'client',
    fullName: 'شركة المدار للتسويق',
    email: 'client@adzair.demo',
    phone: '0501234567',
    password: '12345678',
    city: 'الرياض',
    businessName: 'مدار ديجيتال',
    businessType: 'تجارة إلكترونية',
    createdAt: nowISO(),
  };

  const publisher = {
    id: 'publisher-demo-1',
    role: 'publisher',
    fullName: 'أحمد الناشر',
    email: 'publisher@adzair.demo',
    phone: '0559876543',
    password: '12345678',
    city: 'جدة',
    specialization: 'تقنية وريادة أعمال',
    facebookUrl: 'https://facebook.com/ahmed.publisher.page',
    bio: 'ناشر متخصص بالمحتوى التقني مع جمهور نشط في الخليج.',
    followers: '120000',
    avatar: '',
    createdAt: nowISO(),
  };

  const campaigns = [
    {
      id: 'cmp-1',
      clientId: client.id,
      clientName: client.fullName,
      title: 'حملة إطلاق منتج جديد',
      image: sampleImage,
      postText: 'نرغب بالترويج لمنتجنا الجديد مع عرض افتتاحي لمدة أسبوع.',
      postUrl: 'https://example.com/post/launch',
      pageUrl: 'https://example.com/brand',
      placement: 'منشور رئيسي في الصفحة + ستوري',
      contentType: 'تقني',
      audience: 'شباب 18-35 في السعودية',
      notes: 'يفضل النشر مساءً بين 8-10.',
      status: 'accepted',
      isNewForPublisher: false,
      timeline: [
        { status: 'draft', label: 'تم إنشاء المسودة', at: nowISO() },
        { status: 'pending', label: 'أُرسلت للمراجعة', at: nowISO() },
        { status: 'accepted', label: 'تم قبول الحملة', at: nowISO() },
      ],
      createdAt: nowISO(),
    },
  ];

  localStorage.setItem(KEYS.users, JSON.stringify([client, publisher]));
  localStorage.setItem(KEYS.campaigns, JSON.stringify(campaigns));
  localStorage.setItem(KEYS.initialized, 'true');
};

const get = (key, fallback = []) => JSON.parse(localStorage.getItem(key) || JSON.stringify(fallback));
const set = (key, value) => localStorage.setItem(key, JSON.stringify(value));

export const initializeStore = () => seedData();
export const getUsers = () => get(KEYS.users);
export const getCampaigns = () => get(KEYS.campaigns);
export const getSession = () => get(KEYS.session, null);

export const setSession = (session) => set(KEYS.session, session);
export const clearSession = () => localStorage.removeItem(KEYS.session);

export const registerUser = (user) => {
  const users = getUsers();
  if (users.some((u) => u.email.toLowerCase() === user.email.toLowerCase())) {
    throw new Error('هذا البريد مسجل مسبقاً.');
  }
  const payload = { ...user, id: crypto.randomUUID(), createdAt: nowISO() };
  users.push(payload);
  set(KEYS.users, users);
  return payload;
};

export const loginUser = ({ email, password, role }) => {
  const user = getUsers().find(
    (u) => u.email.toLowerCase() === email.toLowerCase() && u.password === password && u.role === role,
  );
  if (!user) throw new Error('بيانات الدخول غير صحيحة.');
  const session = { userId: user.id, role: user.role };
  setSession(session);
  return user;
};

export const getCurrentUser = () => {
  const session = getSession();
  if (!session) return null;
  return getUsers().find((u) => u.id === session.userId) || null;
};

export const saveCampaign = (campaign) => {
  const campaigns = getCampaigns();
  campaigns.unshift({
    ...campaign,
    id: crypto.randomUUID(),
    status: 'pending',
    isNewForPublisher: true,
    createdAt: nowISO(),
    timeline: [
      { status: 'draft', label: 'تم إنشاء المسودة', at: nowISO() },
      { status: 'pending', label: 'أُرسلت للمراجعة', at: nowISO() },
    ],
  });
  set(KEYS.campaigns, campaigns);
};

export const updateCampaignStatus = (campaignId, status) => {
  const mapLabel = {
    pending: 'قيد المراجعة',
    accepted: 'تم القبول',
    rejected: 'تم الرفض',
  };
  const campaigns = getCampaigns().map((c) =>
    c.id === campaignId
      ? {
          ...c,
          status,
          isNewForPublisher: false,
          timeline: [...(c.timeline || []), { status, label: mapLabel[status], at: nowISO() }],
        }
      : c,
  );
  set(KEYS.campaigns, campaigns);
};

export const markPublisherNotificationsRead = () => {
  const campaigns = getCampaigns().map((c) => ({ ...c, isNewForPublisher: false }));
  set(KEYS.campaigns, campaigns);
};

export const updateUserProfile = (id, data) => {
  const users = getUsers().map((u) => (u.id === id ? { ...u, ...data } : u));
  set(KEYS.users, users);
  return users.find((u) => u.id === id);
};
