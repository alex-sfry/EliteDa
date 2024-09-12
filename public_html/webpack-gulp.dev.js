import MiniCssExtractPlugin from 'mini-css-extract-plugin';
// import CssMinimizerPlugin from 'css-minimizer-webpack-plugin';
// import TerserPlugin from 'terser-webpack-plugin';

export default {
    mode: 'development',
    output: {
        filename: 'js/[name].js',
        assetModuleFilename: 'images/[name][ext][query]',
        clean: false,
    },
    devtool: 'source-map',
    optimization: {
        usedExports: true,
        minimize: false,
        // minimizer: [
        //     new CssMinimizerPlugin({ parallel: true }),
        //     new TerserPlugin({ parallel: true }),
        // ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),
    ],
    module: {
        rules: [
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    MiniCssExtractPlugin.loader,
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