var gulp = require('gulp'),
    concatJs = require('gulp-concat'),
    minifyJs = require('gulp-uglify'),
    less = require('gulp-less'),
    clean = require('gulp-clean');

gulp.task('less', function() {
    return gulp.src(['web-src/less/*.less', 'web-src/css/*.css'])
        .pipe(less({compress: true}))
        .pipe(gulp.dest('web/css/'));
});

gulp.task('lib-js', function() {
    return gulp.src([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js'
    ])
        .pipe(concatJs('all.js'))
        .pipe(minifyJs())
        .pipe(gulp.dest('web/js/'));
});

gulp.task('pages-js', function() {
    return gulp.src([
        'web-src/js/*.js'
    ])
        .pipe(minifyJs())
        .pipe(gulp.dest('web/js/'));
});

gulp.task('fonts', function () {
    return gulp.src([
        'bower_components/bootstrap/fonts/*',
        'web-src/fonts/*'
    ])
        .pipe(gulp.dest('web/fonts/'))
});

gulp.task('clean', function () {
    return gulp.src(['web/css/*', 'web/js/*', 'web/fonts/*'])
        .pipe(clean());
});

gulp.task('default', ['clean'], function () {
    var tasks = ['fonts', 'less', 'lib-js', 'pages-js'];

    tasks.forEach(function (val) {
        gulp.start(val);
    });
});

gulp.task('watch', function () {
    var less = gulp.watch('web-src/less/*.less', ['less']),
        css = gulp.watch('web-src/css/*.css', ['less']),
        js = gulp.watch('web-src/js/*.js', ['pages-js']);
});
