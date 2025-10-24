/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./*.{html,js,php}",
    "./admin/*.{html,js,php}"
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['"Open Sans"', 'sans-serif'],
        'serif': ['"Playfair Display"', 'serif'],
      }
    },
  },
  plugins: [],
}

