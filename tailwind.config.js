const colors = require('tailwindcss/colors') 
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
     "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Http/Livewire/**/*Table.php",
    "./vendor/power-components/livewire-powergrid/resources/views/**/*.php",
    "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php",
    './app/Http/**/*.php',
    './vendor/usernotnull/tall-toasts/config/**/*.php',
    './vendor/usernotnull/tall-toasts/resources/views/**/*.blade.php'
  ],
  presets: [
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"), 
  ],
  darkMode : 'class',
  theme: {
    extend: {
      colors: {
        'primary' : '#FF0207',
        'light' : '#F8F8FA',
        'dark' : '#151515',
        'link' : '#0a66c2',
        'success' : '#00C292',
        'danger' : '#FF0207', //#BB0004
        'warning' : '#FEC107',
        'info' : '#03a9f3',
        'secondary' : '#434343',
        "pg-primary": colors.gray, 
    },
  },
  },
  plugins: [],
}

