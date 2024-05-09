import gulp from 'gulp';
import { webpackDev/* , webpackProd */ } from './gulpfileWebpack.js';
export { webpackDev, webpackProd } from './gulpfileWebpack.js';
// import { scriptsYii2, widgetsScripts } from './gulpfileSripts.js';
export { scriptsYii2, widgetsScripts } from './gulpfileSripts.js';
// import { bsStyles, bsCssMin, purgeCSS, widgetsStyles } from './gulpfileStyles.js';
export { bsStyles, bsCssMin, purgeCSS, widgetsStyles } from './gulpfileStyles.js';
// import { webpackBsDev } from './gulpfileWebpack.js';
export { webpackBsDev } from './gulpfileWebpack.js';
// import { webpackBsProd } from './gulpfileWebpack.js';
export { webpackBsProd } from './gulpfileWebpack.js';
import sync from 'browser-sync';

const browserSync = sync.create('localServer');

export const watch = () => {
    browserSync.init({
        proxy: "elida:8080"
    });

    gulp.watch('./src/script/*.js', () => webpackDev())
        .on('change', (path) => console.log(`File ${path} was changed`))
        .on('unlink', (path) => console.log(`File ${path} was removed`))
        .on('add', (path) => console.log(`File ${path} was added`));

    gulp.watch('./src/styles/scss/*.scss', () => webpackDev())
        .on('change', (path) => console.log(`File ${path} was changed`))
        .on('unlink', (path) => console.log(`File ${path} was removed`))
        .on('add', (path) => console.log(`File ${path} was added`));

    gulp.watch([
        '../widgets/**/*.js',
        '../widgets/**/*.css',
        '!../widgets/**/*.min.js',
        '!../widgets/**/*.min.css'
    ])
        .on('change', (path) => {
            console.log(`File ${path} was changed`);
            browserSync.reload();
        })
        .on('unlink', (path) => {
            console.log(`File ${path} was removed`);
            browserSync.reload();
        })
        .on('add', (path) => {
            console.log(`File ${path} was added`);
            browserSync.reload();
        });
};

// export const bsCss = gulp.series(bsStyles, bsCssMin);
// export const bsCssPurge = gulp.series(bsStyles, purgeCSS, bsCssMin);
export const dev = gulp.series(webpackDev, watch);
export const watcher = gulp.series(watch);

// export const watch = () => {
//     gulp.watch(paths.scripts.srcWatch, scripts);
// };

// export const build = gulp.series(
//     clean, gulp.parallel(scripts), watch
// );