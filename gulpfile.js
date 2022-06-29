
const gulp = require('gulp');
const { task, src, dest, watch, series } = require('gulp');
const log = require('fancy-log');
const fs = require('fs');
const minify = require('gulp-minify');
const sass = require('gulp-sass')(require('sass'));
const htmlmin = require('gulp-htmlmin');
const less = require('gulp-less');
const livereload = require('gulp-livereload');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const plumber = require('gulp-plumber');
const eslint = require('gulp-eslint');
const notify = require("gulp-notify");
const sassLint = require('gulp-sass-lint');
const cache = require('gulp-cached');
const wait = require('gulp-wait')
/*
function getProjectVersion() {
    let file = fs.readFileSync(__dirname+"/access.php", "utf8");
    let pos=file.indexOf("=> '");
    file = file.substr(pos+4);
    pos=file.indexOf("'");
    file = file.substr(0,pos);
    return file;
}

const version = getProjectVersion();
*/
function jsMinify(){
    return (src('./views/js/src/**/*.js')
        .pipe(plumber())
        .pipe(cache('jsMinify'))
        .pipe(minify({ext:{min:'.min.js'}, noSource:true}))
        .pipe(dest('./views/js/min/'))
        .pipe(dest('./data/cdn/js/'))
        .pipe(plumber.stop()));
};

function esLint(){
    return (src('./views/js/src/**/*.js')
        .pipe(cache('esLint'))
        .pipe(eslint({
            envs:[
                'node',
                'es6'
            ],
            rules:{
                'strict': 0,
                'no-var': 2
            },
        }))
        .pipe(plumber())
        .pipe(eslint.format())
        .pipe(eslint.failAfterError())
        /*.on("error", notify.onError('JS Error'))*/);
};


function cssMinify(){
    return (src('./views/css/src/**/*.{scss,css}')
        .pipe(plumber())
        .pipe(cache('cssMinify'))
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(cleanCSS({compatibility: '*'}))
        .pipe(plumber.stop())
        .pipe(dest('./views/css/min/'))
        .pipe(dest('./data/cdn/css/')));
};

function scssLint(){
    return (src('./views/css/src/**/*.{scss,css}')
        .pipe(cache('scssLint'))
        .pipe(sassLint({
            options: {
                formatter: 'stylish',
                'merge-default-rules': false
            },
            rules: {

            }
        }))
        .pipe(plumber())
        .pipe(sassLint.format())
        .pipe(sassLint.failOnError())
        /*.on("error", notify.onError('CSS Error'))*/);
}

function htmlMinify(){
    return (src('./views/html/src/**/*.{php,html}')
        .pipe(plumber())
        .pipe(cache('htmlMinify'))
        .pipe(htmlmin({ collapseWhitespace: true }))
        .pipe(plumber.stop())
        .pipe(dest('./views/html/min/')));
};

function liveReload(){
    return (src('./')
        .pipe(plumber())
        .pipe(wait(100))
        .pipe(less())
        .pipe(dest('css'))
        .pipe(livereload())
        .pipe(plumber.stop()));
}

task('liveReload', liveReload);

task("jsMinify", jsMinify);
task("esLint", esLint);
task("cssMinify", cssMinify);
task("scssLint", scssLint);
task("htmlMinify", htmlMinify);

task("watch", () => {
    watch('./views/js/src/**/*.js', {ignoreInitial:false}, series(jsMinify, esLint));
    watch('./views/css/src/**/*.{scss,css}', {ignoreInitial:false}, series(cssMinify, scssLint));
    watch('./views/html/src/**/*.{php,html}', {ignoreInitial:false}, htmlMinify);
    livereload.listen();
    watch('./', {ignoreInitial:false}, liveReload);
});

task('default', series('watch'));






