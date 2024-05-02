import gulp from 'gulp';
import uglify from 'gulp-uglify';

const paths = {
    scripts: {
        src: '../vendor/yiisoft/yii2/assets/**/*.js',
        dest: '../assetsMin/'
    }
};

export const scripts = () => {
    return gulp.src([paths.scripts.src]/* , { base: 'src/script' } */)
        .pipe(uglify())
        .pipe(gulp.dest(paths.scripts.dest));
};

// export const watch = () => {
//     gulp.watch(paths.scripts.srcWatch, scripts);
// };

// export const build = gulp.series(
//     clean, gulp.parallel(scripts), watch
// );
