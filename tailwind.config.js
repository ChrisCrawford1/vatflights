const { colors: defaultColours } = require('tailwindcss/defaultTheme')

const colours = {
    ...defaultColours,
    ...{
        "dark-blue": {
            "500": "#16213E",
            "900": "#1a1a2e",
        },
    },
}
module.exports = {
    purge: [
        './resources/views/**/*.blade.php',
        './resources/css/**/*.css',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        colors: colours,
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
