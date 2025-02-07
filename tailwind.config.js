import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        container: {
            center: true,
            padding: '2rem',
        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#af1f23',
            },
            boxShadow: {
                '3xl': '0 0 30px rgba(0,0,0,.08)',
                '4xl': '0 0 45px rgba(0,0,0,.09)',
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        color: theme('colors.slate.600'),
                        a: {
                            color: theme('colors.primary'),
                        },
                    },
                },
            }),
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
};
