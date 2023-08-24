const mix = require("laravel-mix");
const fs = require('fs');
const wpPot = require("wp-pot");

mix.options({
    autoprefixer: {
        remove: false,
    },
    processCssUrls: false,
    terser: {
        terserOptions: {
            keep_fnames: true
        }
    }
});

mix.webpackConfig({
    target: "web",
    externals: {
        jquery: "window.jQuery",
        $: "window.jQuery",
        wp: "window.wp",
        _wp_awesome_faq: "window._wp_awesome_faq",
    },
});

mix.sourceMaps(false, 'source-map');

// Disable notification on dev mode
if (process.env.NODE_ENV.trim() !== "production") mix.disableNotifications();

if (process.env.NODE_ENV.trim() === 'production') {

    // Language pot file generator
    wpPot({
        destFile: "languages/wp-awesome-faq.pot",
        domain: "wp-awesome-faq",
        package: "wp-awesome-faq",
        src: "**/*.php",
    });
}

// SCSS to CSS
// mix.sass("dev/scss/style.scss", "assets/css/wp-awesome-faq.min.css");
// mix.sass("dev/scss/premium/wp-awesome-faq-pro-styles.scss", "Pro/assets/css/wp-awesome-faq-pro.min.css");

// Scripts to js - regular
mix.scripts( 'src/block.js', 'assets/js/wp-awesome-faq.js' );

// Third Party Plugins Support
// fs.readdirSync('dev/scss/plugins').forEach(
//     file => {
//         mix.sass('dev/scss/plugins/' + file, 'assets/css/plugins/' + file.substring(1).replace('.scss', '.min.css'));
//     }
// );

// fs.readdirSync('dev/scss/premium/plugins/').forEach(
//     file => {
//         mix.sass('dev/scss/premium/plugins/' + file, 'Pro/assets/css/plugins/' + file.substring(1).replace('.scss', '.min.css'));
//     }
// );
