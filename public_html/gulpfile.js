import gulp from 'gulp';
import { webpackDev, webpackProd } from './gulpfileWebpack.js';
export { webpackDev, webpackProd } from './gulpfileWebpack.js';
import { scriptsYii2, widgetsScripts } from './gulpfileSripts.js';
export { scriptsYii2, widgetsScripts } from './gulpfileSripts.js';
import { bsStyles, bsStylesMin, purgeCSS, widgetsStyles } from './gulpfileStyles.js';
export { bsStyles, bsStylesMin, purgeCSS, widgetsStyles } from './gulpfileStyles.js';
// import { webpackBsDev } from './gulpfileWebpack.js';
export { webpackBsDev } from './gulpfileWebpack.js';
// import { webpackBsProd } from './gulpfileWebpack.js';
export { webpackBsProd } from './gulpfileWebpack.js';
import { vendorJS } from './gulpfileSripts.js';
export { vendorJS } from './gulpfileSripts.js';
import sync from 'browser-sync';
import { deleteAsync } from 'del';

/* run cleanProd after build to remove non-minified files */

const browserSync = sync.create('localServer');
let syncMode = false;

const enableSync = () => {
    return Promise.resolve(syncMode = true);
};

export const clean = async () => {
    return await deleteAsync([
        './templates/css/*',
        './templates/js/*',
        './templates/fonts/*',
        './templates/iamges/*',
    ]);
};

export const cleanProd = async () => {
    return await deleteAsync([
        './templates/css/bootstrap.css*',
        './templates/css/main.css*',
        './templates/js/bootstrap.js*',
        './templates/js/main.js*',
    ]);
};

export const images = async () => {
    await deleteAsync(['./templates/images/*']);
    return gulp.src('./src/images/**/*')
        .pipe(gulp.dest('./templates/images/'));
};

export const watch = () => {
    console.log('syncMode - ', syncMode);
    syncMode && browserSync.init({
        proxy: "elida:8080"
    });

    gulp.watch('./src/images/**/*', () => images())
        .on('change', (path) => console.log(`File ${path} was changed`))
        .on('unlink', (path) => console.log(`File ${path} was removed`))
        .on('add', (path) => console.log(`File ${path} was added`));

    gulp.watch('./src/vendorJS/**/*.js', () => vendorJS())
        .on('change', (path) => console.log(`File ${path} was changed`))
        .on('unlink', (path) => console.log(`File ${path} was removed`))
        .on('add', (path) => console.log(`File ${path} was added`));

    gulp.watch('./src/script/*.js', () => webpackDev())
        .on('change', (path) => console.log(`File ${path} was changed`))
        .on('unlink', (path) => console.log(`File ${path} was removed`))
        .on('add', (path) => console.log(`File ${path} was added`));

    gulp.watch('./src/styles/scss/*.scss', () => webpackDev())
        .on('change', (path) => console.log(`File ${path} was changed`))
        .on('unlink', (path) => console.log(`File ${path} was removed`))
        .on('add', (path) => console.log(`File ${path} was added`));
    
    gulp.watch('./src/styles/bootstrapSCSS/*.scss', () => bsStyles())
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

/* dev mode w/o browserSync */
export const dev = gulp.series(gulp.parallel(bsStyles, vendorJS, images, webpackDev), watch);

/* dev mode with browserSync */
export const devSync = gulp.series(
    enableSync,
    gulp.parallel(bsStyles, vendorJS, images, webpackDev),
    watch
);

/* compile and minify Bootstrap with purgeCCC */
export const bsProdPurge = gulp.series(webpackDev, bsStyles, purgeCSS, bsStylesMin);

/* compile and minify Bootstrap w/o purgeCCC */
export const bsProd = gulp.series(webpackDev, bsStyles, bsStylesMin);

export const widgets = gulp.parallel(widgetsStyles, widgetsScripts);

/* minify all w/o purgeCSS */
export const minAll = gulp.series(
    clean,
    gulp.series(
        gulp.parallel(vendorJS, images),
        bsProd,
        gulp.parallel(bsStyles, widgets, scriptsYii2, webpackProd)
    ),
);

/* minify all with purgeCSS */
export const build = gulp.series(
    clean,
    gulp.series(
        gulp.parallel(vendorJS, images),
        bsProdPurge,
        gulp.parallel(widgets, scriptsYii2, webpackProd)
    )
);

/* run cleanProd after build to remove non-minified files */

export default dev;
