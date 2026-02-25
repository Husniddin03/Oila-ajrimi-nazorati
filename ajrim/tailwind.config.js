/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'fon': '#0d1117',
        'fon2': '#161b22',
        'fon3': '#1c2333',
        'karta': '#21262d',
        'chegara': '#30363d',
        'aksent': '#e94560',
        'aksent2': '#ff6b6b',
        'yashil': '#3fb950',
        'sariq': '#d29922',
        'moviy': '#58a6ff',
        'matn': '#e6edf3',
        'matn2': '#7d8590',
        'matn3': '#484f58'
      },
      fontFamily: {
        'playfair': ['Playfair Display', 'serif'],
        'dm': ['DM Sans', 'sans-serif']
      }
    },
  },
  plugins: [],
}
