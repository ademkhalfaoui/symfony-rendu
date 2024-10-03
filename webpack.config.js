const Encore = require('@symfony/webpack-encore');

// Configure runtime environment
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // Directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // Public path used by the web server to access the output path
    .setPublicPath('/build')
    
    // Entry point for your app (JS/CSS)
    .addEntry('app', './assets/app.js')

    // Optimization: Split your files into smaller chunks
    .splitEntryChunks()

    // Enable single runtime chunk (recommended for most cases)
    .enableSingleRuntimeChunk()

    // Cleaning up the output directory before each build
    .cleanupOutputBeforeBuild()

    // Disable notifications to prevent the SnoreToast error
    .disableNotifications()

    // Enable source maps for development, disabled in production
    .enableSourceMaps(!Encore.isProduction())

    // Enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // Babel configuration for JavaScript compatibility
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23'; // CoreJS version
    })

    // Uncomment to enable Sass/SCSS support
    // .enableSassLoader()

    // Uncomment to enable TypeScript support
    // .enableTypeScriptLoader()

    // Uncomment to enable React support
    // .enableReactPreset()

    // Uncomment for jQuery support
    // .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
