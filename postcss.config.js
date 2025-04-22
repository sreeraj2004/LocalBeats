module.exports = {
    plugins: {
        'postcss-import': {},
        'postcss-nesting': {},
        '@tailwindcss/postcss': {},
        autoprefixer: {},
        'postcss-preset-env': {
            stage: 3,
            features: {
                'nesting-rules': true
            }
        }
    }
}; 