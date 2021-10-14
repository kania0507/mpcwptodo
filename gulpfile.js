var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var rename = require("gulp-rename");


gulp.task('sass', async function () {

  return gulp.src('admin/scss/main.scss')
  .pipe(sass({outputStyle: 'compressed'})
  .on('error', sass.logError))
  .pipe(rename('mpc-admin.css'))
  .pipe(gulp.dest('./admin/css'));  
});