const { colors: defaultColours } = require('tailwindcss/defaultTheme')

const colours = {
    ...defaultColours,
    ...{
        "havelock": {
            "500": "#4D7CDC"
        },
        "calypso": {
          "500": "#326495",
        },
        "stone": {
            "500": "#121F31"
        },
        "quill": {
            "400": "#E4E4DB",
            "500": "#D2D2D1",
        }
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
