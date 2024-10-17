/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: 'jit', // Just-In-Time mode for Tailwind CSS
  content: [
    './public/**/*.{php,html}', // Match all PHP and HTML files in public and its subdirectories
    './views/**/*.{php,html}'   // Match all PHP and HTML files in views and its subdirectories
  ],
  theme: {
    extend: {
      // You can add custom theme extensions here
    },
  },
  plugins: [
    // Add any Tailwind plugins here
  ],
}
