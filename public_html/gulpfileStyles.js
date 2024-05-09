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
    return gulp.src('../widgets/**/*.css')
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

export const bsCssMin = () => {
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
                '../views/**/*.php',
                '../widgets/**/*.php',
                '../widgets/**/*.js',
                '../assetsMin/**/*.js'
            ],
            sourceMap: true
        }))
        .pipe(gulp.dest('./templates/css/'));
};