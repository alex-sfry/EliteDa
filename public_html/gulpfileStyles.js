import gulp from 'gulp';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import rename from 'gulp-rename';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import purgecss from 'gulp-purgecss';

const sass = gulpSass(dartSass);

export const widgetsStyles = () => {
    const plugins = [
        autoprefixer(),
        cssnano()
    ];
    return gulp.src(['../widgets/**/*.css', '!../widgets/**/*.min.css'])
        .pipe(sourcemaps.init())
        .pipe(postcss(plugins))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(function (file) {
            return file.base;
        }));
};

export const bsStyles = () => {
    return gulp.src('./src/styles/bootstrapSCSS/bootstrap.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./templates/css/'));
};

export const bsStylesMin = () => {
    const plugins = [cssnano()];
    return gulp.src('./templates/css/bootstrap.css')
        .pipe(sourcemaps.init())
        .pipe(postcss(plugins))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./templates/css/'));
};

export const purgeCSS = () => {
    return gulp.src('./templates/css/bootstrap.css')
        .pipe(purgecss({
            content: [
                './templates/**/*.js',
                '../admin/assets/*.js',
                '../views/**/*.php',
                '../widgets/**/*.php',
                '../widgets/**/*.js',
                '../assetsMin/**/*.js',
                '../vendor/yiisoft/yii2/widgets/**/*.js',
                '../vendor/yiisoft/yii2/widgets/**/*.php',
            ],
            safelist: [
                'page-item',
                'page-link',
                'prev-page',
                'last-page',
                'pagination',
                'first',
                'last',
                'disabled',
                'active'
            ],
            sourceMap: true
        }))
        .pipe(gulp.dest('./templates/css/'));
};