/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  darkMode: "class",
  theme: {
    colors: {
      transparent: "transparent",
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
    extend: {
      boxShadow: {
        light: "10px 10px 40px #00000010",
        dark: "10px 10px 40px #317DC610",
      },
      transitionTimingFunction: {
        "nav-buzier": "cubic-bezier(0.71, 0.01, 0.24, 0.99)",
      },
      transformOrigin: {
        "left-top": "left top",
      },
    },
  },
  plugins: [],
};
