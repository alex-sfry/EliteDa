import path from 'path';
import {fileURLToPath} from 'url';
// import HtmlWebpackPlugin from 'html-webpack-plugin';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import CssMinimizerPlugin from 'css-minimizer-webpack-plugin';
import TerserPlugin from 'terser-webpack-plugin';

let mode = 'development';
let watch = false;
if (process.env.NODE_ENV === 'production' || process.env.NODE_ENV === 'productionDev') {
    mode = 'production';
    if (process.env.NODE_ENV === 'productionDev') watch = true;
}
console.log(mode + ' mode');

export default {
    mode: mode,
    watch: watch,
    entry: {
        main: './src/script/main.js',
        // bootstrap: './src/script/bootstrapJS/bootstrap.js',
    },
    output: {
        path: path.resolve(path.dirname(fileURLToPath(import.meta.url)), './templates'),
        filename: 'js/[name].min.js',
        assetModuleFilename: 'images/[name][ext][query]',
        clean: false,
    },
    devServer: {
        open: true,
        static: {
            directory: './',
            watch: true,
        },
    },
    devtool: 'source-map',
    optimization: {
        usedExports: true,
        // minimize: true,
        minimizer: [
            new CssMinimizerPlugin({ parallel: true }),
            new TerserPlugin({ parallel: true }),
        ],
        splitChunks: {
            cacheGroups: {
                bootstrap: {
                    test: /bootstrap.scss/,
                    name: 'bootstrap',
                    type: 'css/mini-extract',
                    chunks: 'all',
                    enforce: true,
                },
                // styles: {
                //     test: /style.scss/,
                //     name: 'main.min',
                //     type: 'css/mini-extract',
                //     chunks: 'all',
                //     enforce: true,
                // },
                // stylesCSS: {
                //     test: /main.css/,
                //     name: 'styles.min',
                //     type: 'css/mini-extract',
                //     chunks: 'all',
                //     enforce: true,
                // },
            },
        },
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].min.css',
        }),
        // new HtmlWebpackPlugin({
        //     template: path.resolve(path.dirname(fileURLToPath(import.meta.url)), 'src/page.html'),
        //     filename: 'page.html',
        // }),
    ],
    module: {
        rules: [
            // {
            //     test: /\.html$/i,
            //     loader: "html-loader",
            // },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    (mode === 'development') ? 'style-loader' : MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                plugins: [
                                    [
                                        'postcss-preset-env',
                                        {
                                            // Options
                                        },
                                    ],
                                ],
                            },
                        },
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sassOptions: {
                                indentWidth: 4,
                                minimize: true,
                                outputStyle: "compressed"
                            },
                        },
                    },
                ],
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif)$/i,
                type: 'asset/resource',
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'fonts/[name][ext]',
                },
            },
            // JavaScript
            {
                test: /\.m?js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
        ],
    },
};