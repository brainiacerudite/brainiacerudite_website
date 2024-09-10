/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    colors: {
      white: "#FFFFFF",
      black: "#000000",
      "input-placeholder-color": "#9E9E9E",
      dark: {
        "heading-color": "#F5F5F5",
        "secondary-color": "#2A2A48",
        "text-color": "#9E9E9E",
        "primary-color": "#317DC6",
        "background-color": "#030411",
        "input-background-color": "#03041150",
      },
      light: {
        "heading-color": "#1F1F1F",
        "secondary-color": "#FFFFFF",
        "text-color": "#5E5E5E",
        "primary-color": "#317DC6",
        "background-color": "#F5F5F5",
        "input-background-color": "#F5F5F5",
      },
    },
    extend: {},
  },
  plugins: [],
};
