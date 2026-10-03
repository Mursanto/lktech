const purgecss = process.env.NODE_ENV === 'production'
    ? require('@fullhuman/postcss-purgecss')({
        content: [
            './resources/views/**/*.blade.php',
            './resources/js/**/*.js',
        ],
        defaultExtractor: content => content.match(/[\w-/:[\]!.]+(?<!:)/g) || [],
        safelist: {
            pattern: /^(bx|bxs|bxl|bg-|text-|border-|from-|to-|via-|hover:|focus:|aria-|group-|translate-|rotate-|scale-|opacity-|shadow-)/,
        },
    })
    : [];

module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
};
