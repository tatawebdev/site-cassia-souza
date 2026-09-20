import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#481e4d',
                    100: '#f3eaf3',
                    600: '#3b173d',
                },
            },
        },
    },

    corePlugins: {
        // As páginas Blade do site usam Bootstrap; o reset do Tailwind (preflight)
        // quebraria esses estilos, então mantemos só as classes utilitárias.
        preflight: false,
    },

    plugins: [forms],
};
