import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                ninich: {
                    rose: '#B76E79',
                    'rose-dark': '#9C5561',
                    gold: '#C9A24B',
                    blush: '#FDF6F3',
                    'blush-2': '#F7E9E4',
                    ink: '#3D2C2E',
                    muted: '#8A7275',
                    line: '#EADCD6',
                },
            },
            boxShadow: {
                ninich: '0 12px 30px rgba(122,74,80,.08)',
                'ninich-lg': '0 18px 40px rgba(122,74,80,.12)',
            },
        },
    },

    plugins: [forms],
};
