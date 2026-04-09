import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,jsx}'],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#f4f7ff',
          100: '#e9efff',
          500: '#4f74ff',
          600: '#3f61e6',
          700: '#2f4bc4',
          900: '#1a2454',
        },
      },
      boxShadow: {
        soft: '0 10px 35px rgba(26,36,84,0.08)',
      },
    },
  },
  plugins: [forms, typography],
};
