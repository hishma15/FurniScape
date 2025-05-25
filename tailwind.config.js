//tailwind.config.js
export default{
    content: [
        "./**/*.php", //all php files
        "./public/**/*.php", // or wherever your view are
        "./*.php", //This will include all .php files in the root folder
        "./views/*.php", // if how.php is now in a new folder
        "./views/layout/*.php",
    ],
    theme: {
        extend: {

            colors: {
                brown: "#967F71",
                black: "#3B3937",
                beige: "#F5F5F3",
                grayBack: "#F4F4F4",
                // beige: "#EDE8D0",
                btnHoverBrown: "#7e6b61",
                customyellow: "#F8C8DC",
    
            },
  
            fontFamily: {
                fancy: ['"Comic Sans MS"','cursile'],
                lustria: ['Lustria', 'serif'],
                montserrat: ['Montserrat', 'sans-serif']
            },

            animation: {
                fade: 'fadeOut 2s ease-out forwards'
            },

            keyframes: {
                fadeOut: {
                    '0%': {opacity: 1 },
                    '100%': {opacity: 0 }
                }
            },

        },
    },
};