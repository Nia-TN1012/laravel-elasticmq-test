const mix = require( 'laravel-mix' );
const glob = require( 'glob' );

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// TypeScript ( excluding type definition file ( *.d.ts ) )
glob.sync( 'resources/js/*.ts' ).map( function( file ) {
    if( !file.endsWith( '.d.ts' ) ) {
        mix.ts( file, 'public/js' )
    }
} )
// JavaScript ( excluding bootstrap.js )
glob.sync( 'resources/js/*.js' ).map( function( file ) {
    if( !file.endsWith( 'bootstrap.js' ) ) {
        mix.js( file, 'public/js' )
    }
} )
// Sass ( excluding files starting with '_' )
glob.sync( 'resources/sass/*.scss' ).map( function( file ) {
    if( !file.startsWith( 'resources/sass/_' ) ) {
        mix.sass( file, 'public/css' );
    }
} )

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                loader: 'ts-loader',
                options: {
                    appendTsSuffixTo: [/\.vue$/]
                },
                exclude: /node_modules/
            }
        ]
    },
    resolve: {
        extensions: ['*', '.js', '.jsx', '.ts', '.tsx']
    }
})
.extract();