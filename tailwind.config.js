/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/View/Components/**/*.php",
    "./app/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f0f9ff',
          100: '#e0f2fe',
          200: '#bae6fd',
          300: '#7dd3fc',
          400: '#38bdf8',
          500: '#0ea5e9',
          600: '#0284c7',
          700: '#0369a1',
          800: '#075985',
          900: '#0c4a6e',
          950: '#082f49',
        },
        // Thème professionnel dark et light
        dark: {
          bg: '#121212',
          surface: '#1e1e1e',
          border: '#2d2d2d',
          divider: '#383838',
          text: '#e2e2e2',
          textSecondary: '#b3b3b3',
          accent: '#0ea5e9',
          accentHover: '#0284c7',
          button: '#0ea5e9',
          buttonHover: '#0284c7',
          header: '#121212',
          input: '#2d2d2d',
          card: '#1e1e1e',
          warning: '#e57373',
          success: '#81c784',
        }
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
  darkMode: 'class',
}