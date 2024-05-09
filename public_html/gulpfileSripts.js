import gulp from 'gulp';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';
import babel from 'gulp-babel';
import rename from 'gulp-rename';
// import sync from 'browser-sync';

export const widgetsScripts = () => {
    return gulp.src(['../widgets/**/*.js', '!../widgets/**/*.min.js'])
        .pipe(sourcemaps.init())
        .pipe(babel())
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(function (file) {
            return file.base;
        }));
};

export const scriptsYii2 = () => {
    return gulp.src('../vendor/yiisoft/yii2/assets/**/*.js')
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('../assetsMin/'));
};
