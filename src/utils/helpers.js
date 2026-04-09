export const readFileAsDataURL = (file) =>
  new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => resolve(reader.result);
    reader.onerror = reject;
    reader.readAsDataURL(file);
  });

export const formatDate = (iso) =>
  new Date(iso).toLocaleString('ar-SA', { dateStyle: 'medium', timeStyle: 'short' });
