/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],
  theme: {
    fontFamily:{
        'montserrat': ['Montserrat', 'sans-serif'],
    },
    container: {
      center: true,  // Center the container
      padding: '2rem',  // Set default padding for all containers
      screens: {
        sm: '100%',  // Full width for small screens
        md: '768px', // Custom width for medium screens
        lg: '1024px', // Custom width for large screens
        xl: '1280px', // Custom width for extra-large screens
      },
    },
    extend: {
        clipPath: {
            'fullscreen': 'polygon(0 0, 100% 0, 100% 100%, 0 100%)',
            'noscreen': 'polygon(0 0, 100% 0, 100% 0, 0 0)',
          },
          animation: {
            pageloadingprogress: 'pageloadingprogress 2s linear infinite',  // Corrected typo here and added linear
        },
        keyframes: {
            pageloadingprogress: {  // Corrected typo here
                '0%': { width: '0%', left: '0' },
                '50%': { width: '100%', left: '0' },
                '100%': { width: '0%', left: '100%' },
            }
        },
    },
  },
  plugins: [
    require('tailwind-clip-path'),
  ],
}

