/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
    ],
    safelist: [
        "sm:max-w-sm",
        "sm:max-w-md",
        "md:max-w-lg",
        "md:max-w-xl",
        "lg:max-w-2xl",
        "lg:max-w-3xl",
        "xl:max-w-4xl",
        "xl:max-w-5xl",
        "2xl:max-w-6xl",
        "2xl:max-w-7xl",
    ],
    theme: {
        extend: {
            fontFamily: {
                'sans': ['nunito', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'xxs': ['0.5rem', '0.7rem'],
            },
            colors: {
                transparent: 'transparent',
                'body-bg': '#f8fafc',
                'navbar-bg': '#6c757d',
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        function ({addBase, theme}) {
            function extractColorVars(colorObj, colorGroup = '') {
                return Object.keys(colorObj).reduce((vars, colorKey) => {
                    const value = colorObj[colorKey];
                    const cssVariable = colorKey === "DEFAULT" ? `--color${colorGroup}` : `--color${colorGroup}-${colorKey}`;

                    const newVars =
                        typeof value === 'string'
                            ? {[cssVariable]: value}
                            : extractColorVars(value, `-${colorKey}`);

                    return {...vars, ...newVars};
                }, {});
            }

            addBase({
                ':root': extractColorVars(theme('colors')),
            });
        }
    ]
}
