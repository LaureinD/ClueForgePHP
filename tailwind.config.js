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
        extend: {
            fontFamily: {
                "wix": ["WixMadeforText", "sans-serif"],
            },
            colors: {
                "primary": "#1977D6",
                "primary-light": "#D2E6FC",
                "secondary": "#a6b3c1",
                "secondary-light": "#E3E8ED",
                "accent": "#4ECAC2",
                "accent-light": "#DCF4F3",
                "background": "#EFEFEF",
                "surface": "#FFFFFF",
                "text-primary": "#1C1C27",
                "text-muted": "#6B7280",
                "success": "#22C55E",
                "success-light": "#D3F3DF",
                "warning": "#F9B931",
                "warning-light": "#FEF1D6",
                "danger": "#EF5F5F",
                "danger-light": "#FCDFDF",
            },
            screens: {
                "3xl": "120rem",
            },
        },
    },
    plugins: [],
};
