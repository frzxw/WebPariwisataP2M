import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */

export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    darkMode: "class", // Enable manual dark mode using class
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", ...defaultTheme.fontFamily.sans],
                montserrat: ["Montserrat", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                darkGreen: "#304835",
                baseGreen: "#3A5A40",
                whiteGreen: "#F7F8F3",
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
