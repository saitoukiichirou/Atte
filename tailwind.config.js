const defaultTheme = require('tailwindcss/defaultTheme');

// module.exports = {
//     purge: [
//         './storage/framework/views/*.php',
//         './resources/**/*.blade.php',
//         './resources/**/*.js',
//         './resources/**/*.vue',
//     ],
//     darkMode: false, // or 'media' or 'class'
//     theme: {
//         extend: {},
//     },
//     variants: {
//         extend: {},
//     },
//     plugins: [],
// }



module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
