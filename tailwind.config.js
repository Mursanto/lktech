const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
                montserrat: ['Montserrat', 'sans-serif'],
            },
            colors: {
                brand: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    500: '#3b82f6', 
                    600: '#2563eb', 
                    700: '#1d4ed8',
                },
                natural: {
                    50: '#f6f8f7',
                    100: '#edf1f0',
                    200: '#d5dfdc',
                    300: '#b4c7c2',
                    400: '#8ba6a0',
                    500: '#698a83',
                    600: '#526e69',
                    700: '#435a56',
                    800: '#394b48',
                    900: '#313e3c',
                    950: '#192220',
                },
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
