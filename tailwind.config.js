import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                // We will stick to standard sans for now, but can swap this for a rounded, playful font later
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                bedtime: {
                    midnight: '#172348',
                    blue: '#2B43A1',
                    starlight: '#4BB4F9',
                    orange: '#F67E14',
                    yellow: '#FFCD29',
                    cloud: '#F4F7FB', // A very soft, cool off-white for backgrounds
                }
            },
            boxShadow: {
                'magical': '0 10px 25px -5px rgba(246, 126, 20, 0.4), 0 8px 10px -6px rgba(246, 126, 20, 0.1)',
                'soft': '0 4px 20px -2px rgba(43, 67, 161, 0.15)',
            }
        },
    },

    plugins: [forms],
};