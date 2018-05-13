var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .autoProvidejQuery()
    .createSharedEntry('js/common', ['jquery'])
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/main', './assets/css/main.scss')
    .addStyleEntry('css/app', './assets/css/app.scss')
    .addStyleEntry('css/login', './assets/css/login.scss')
;

module.exports = Encore.getWebpackConfig();
