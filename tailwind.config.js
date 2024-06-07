/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",    
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./node_modules/flowbite/**/*.js",

  ],
  theme: {
    screens: {
      'vsm': '140px',
      'phone': '480px',
      'tablet': '640px',
      'laptop': '1024px',
      'desktop': '1280px',
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}