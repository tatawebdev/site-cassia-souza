/**
 * Tailwind do tema novo do site público (resources/views/novo).
 * Roda em paralelo ao tema antigo (Bootstrap) até a migração terminar;
 * por isso o preflight fica ligado aqui — essas páginas não carregam o template.
 */

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/novo/**/*.blade.php',
        './resources/views/components/novo/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                plum: {
                    DEFAULT: '#590854',
                    bright: '#6E1468',
                    deep: '#3A0637',
                    night: '#24041F',
                },
                champagne: {
                    DEFAULT: '#EFCF9F',
                    light: '#F5DDB8',
                    // estrelas sobre fundo claro (o champagne puro some no branco)
                    dark: '#C8913F',
                },
                gold: {
                    ink: '#8A5C17',
                },
                mist: '#F5F1F4',
                ink: {
                    DEFAULT: '#3B2F3A',
                    soft: '#6A5D68',
                },
                line: '#E6DDE4',
                'on-plum': '#F3E6F1',
            },
            fontFamily: {
                display: ['Newsreader', 'Georgia', 'serif'],
                sans: ['"Public Sans"', 'system-ui', 'sans-serif'],
            },
            transitionTimingFunction: {
                'out-soft': 'cubic-bezier(0.22, 0.8, 0.2, 1)',
            },
            keyframes: {
                rise: {
                    from: { transform: 'translateY(105%)' },
                    to: { transform: 'translateY(0)' },
                },
                fade: {
                    from: { opacity: '0' },
                    to: { opacity: '1' },
                },
                unveil: {
                    from: { clipPath: 'inset(0 0 0 100%)' },
                    to: { clipPath: 'inset(0 0 0 0)' },
                },
            },
            animation: {
                rise: 'rise 900ms cubic-bezier(0.22, 0.8, 0.2, 1) both',
                fade: 'fade 700ms ease-out 380ms both',
                unveil: 'unveil 1200ms cubic-bezier(0.22, 0.8, 0.2, 1) 100ms both',
            },
        },
    },
};
