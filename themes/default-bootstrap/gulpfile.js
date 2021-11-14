var gulp = require('gulp');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var terser = require('gulp-terser');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var wait = require('gulp-wait');


/* Pantry Landing Page Starts */
// gulp.task('bundleCSS', function(){
//   return gulp.src('./sass/campaigns/pantry/pantry.scss')
//     .pipe(wait(500))
//     .pipe(sass(
//         {
//           'includePaths' : ['./sass/campaigns/pantry/'],
//           'outputStyle' : 'compressed'
//         }
//       )
//       .on('error', sass.logError)
//     )
//     .pipe(rename({suffix: '.min'}))
//     .pipe(gulp.dest('./css/campaigns'))
// });

// gulp.task('bundleJS', function() {
//   return gulp.src([
//       './js/campaigns/pantry/jquery.js', 
//       './js/campaigns/pantry/jquery-validation.js',
//       './js/campaigns/pantry/slick.js',
//       './js/campaigns/pantry/main.js'
//     ])
//     .pipe(wait(500))
//     .pipe(concat('pantry.js'))
//     .pipe(rename({suffix: '.min'}))
//     .pipe(uglify().on('error', function(uglify) {
//       console.error(uglify.message);
//       this.emit('end');
//     }))
//     .pipe(gulp.dest('./js/campaigns'));
// });

// gulp.task('watch', ['bundleCSS','bundleJS'], function (){
//   gulp.watch('./sass/campaigns/pantry/**/*.scss', ['bundleCSS']);
//   gulp.watch('./js/campaigns/pantry/*.js', ['bundleJS']);
// });
/* Pantry Landing Page Ends */


/* Office Supplies Landing Page Starts */
// gulp.task('bundleCSS', function(){
//   return gulp.src('./sass/campaigns/office-supplies/office-supplies.scss')
//     .pipe(wait(500))
//     .pipe(sass(
//         {
//           'includePaths' : ['./sass/campaigns/office-supplies/'],
//           'outputStyle' : 'compressed'
//         }
//       )
//       .on('error', sass.logError)
//     )
//     .pipe(rename({suffix: '.min'}))
//     .pipe(gulp.dest('./css/campaigns'))
// });

// gulp.task('bundleJS', function() {
//   return gulp.src([
//       './js/campaigns/common/jquery.js', 
//       './js/campaigns/common/jquery-validation.js',
//       './js/campaigns/common/slick.js',
//       './js/campaigns/office-supplies/main.js'
//     ])
//     .pipe(wait(500))
//     .pipe(concat('office-supplies.js'))
//     .pipe(rename({suffix: '.min'}))
//     .pipe(uglify().on('error', function(uglify) {
//       console.error(uglify.message);
//       this.emit('end');
//     }))
//     .pipe(gulp.dest('./js/campaigns'));
// });

// gulp.task('watch', ['bundleCSS','bundleJS'], function (){
//   gulp.watch('./sass/campaigns/office-supplies/**/*.scss', ['bundleCSS']);
//   gulp.watch('./js/campaigns/*.js', ['bundleJS']);
// });
/* Office Supplies Landing Page Ends */


/* House Keeping Landing Page Starts */
// gulp.task('bundleCSS', function(){
//   return gulp.src('./sass/campaigns/house-keeping/house-keeping.scss')
//     .pipe(wait(500))
//     .pipe(sass(
//         {
//           'includePaths' : ['./sass/campaigns/house-keeping/'],
//           'outputStyle' : 'compressed'
//         }
//       )
//       .on('error', sass.logError)
//     )
//     .pipe(rename({suffix: '.min'}))
//     .pipe(gulp.dest('./css/campaigns'))
// });

// gulp.task('bundleJS', function() {
//   return gulp.src([
//       './js/campaigns/common/jquery.js', 
//       './js/campaigns/common/jquery-validation.js',
//       './js/campaigns/common/slick.js',
//       './js/campaigns/house-keeping/main.js'
//     ])
//     .pipe(wait(500))
//     .pipe(concat('house-keeping.js'))
//     .pipe(rename({suffix: '.min'}))
//     .pipe(uglify().on('error', function(uglify) {
//       console.error(uglify.message);
//       this.emit('end');
//     }))
//     .pipe(gulp.dest('./js/campaigns'));
// });

// gulp.task('watch', ['bundleCSS','bundleJS'], function (){
//   gulp.watch('./sass/campaigns/house-keeping/**/*.scss', ['bundleCSS']);
//   gulp.watch('./js/campaigns/*.js', ['bundleJS']);
// });
/* House Keeping Landing Page Ends */

/* Electronics Landing Page Starts */
// gulp.task('bundleCSS', function(){
//   return gulp.src('./sass/campaigns/electronics/electronics.scss')
//     .pipe(wait(500))
//     .pipe(sass(
//         {
//           'includePaths' : ['./sass/campaigns/electronics/'],
//           'outputStyle' : 'compressed'
//         }
//       )
//       .on('error', sass.logError)
//     )
//     .pipe(rename({suffix: '.min'}))
//     .pipe(gulp.dest('./css/campaigns'))
// });

// gulp.task('bundleJS', function() {
//   return gulp.src([
//       './js/campaigns/common/jquery.js', 
//       './js/campaigns/common/jquery-validation.js',
//       './js/campaigns/common/slick.js',
//       './js/campaigns/electronics/parallaxify.js',
//       './js/campaigns/electronics/main.js'
//     ])
//     .pipe(wait(500))
//     .pipe(concat('electronics.js'))
//     .pipe(rename({suffix: '.min'}))
//     .pipe(uglify().on('error', function(uglify) {
//       console.error(uglify.message);
//       this.emit('end');
//     }))
//     .pipe(gulp.dest('./js/campaigns'));
// });

// gulp.task('watch', ['bundleCSS','bundleJS'], function (){
//   gulp.watch('./sass/campaigns/electronics/**/*.scss', ['bundleCSS']);
//   gulp.watch('./js/campaigns/electronics/*.js', ['bundleJS']);
// });
/* Electronics Landing Page Ends */

/* Taski Landing Page Starts */
// gulp.task('bundleCSS', function(){
//   return gulp.src('./sass/campaigns/taski/taski.scss')
//     .pipe(wait(500))
//     .pipe(sass(
//         {
//           'includePaths' : ['./sass/campaigns/taski/'],
//           'outputStyle' : 'compressed'
//         }
//       )
//       .on('error', sass.logError)
//     )
//     .pipe(rename({suffix: '.min'}))
//     .pipe(gulp.dest('./css/campaigns'))
// });

// gulp.task('bundleJS', function() {
//   return gulp.src([
//       './js/campaigns/common/jquery.js', 
//       './js/campaigns/common/jquery-validation.js',
//       './js/campaigns/common/slick.js',
//       './js/campaigns/taski/wow.js',
//       './js/campaigns/taski/main.js'
//     ])
//     .pipe(wait(500))
//     .pipe(concat('taski.js'))
//     .pipe(rename({suffix: '.min'}))
//     .pipe(uglify().on('error', function(uglify) {
//       console.error(uglify.message);
//       this.emit('end');
//     }))
//     .pipe(gulp.dest('./js/campaigns'))
// });

// gulp.task('watch', ['bundleCSS','bundleJS'], function (){
//   gulp.watch('./sass/campaigns/taski/**/*.scss', ['bundleCSS']);
//   gulp.watch('./js/campaigns/taski/*.js', ['bundleJS']);
// });
/* Taski Landing Page Ends */

/* Bottomline Landing Page starts **/

// gulp.task('bundleCSS', function(){
//   return gulp.src('./sass/campaigns/bottomline/bottomline.scss')
//     .pipe(wait(500))
//     .pipe(sass(
//         {
//           'includePaths' : ['./sass/campaigns/bottomline/'],
//           'outputStyle' : 'compressed'
//         }
//       )
//       .on('error', sass.logError)
//     )
//     .pipe(rename({suffix: '.min'}))
//     .pipe(gulp.dest('./css/campaigns'))
// });

// gulp.task('bundleJS', function() {
//   return gulp.src([
//       './js/campaigns/bottomline/jquery.js', 
//       './js/campaigns/bottomline/jquery-validation.js',
//       './js/campaigns/bottomline/jquery-additional-methods.js',
//       './js/campaigns/bottomline/slick.js',
//       './js/campaigns/bottomline/main.js'
//     ])
//     .pipe(wait(500))
//     .pipe(concat('bottomline.js'))
//     .pipe(rename({suffix: '.min'}))
//     .pipe(uglify().on('error', function(uglify) {
//       console.error(uglify.message);
//       this.emit('end');
//     }))
//     .pipe(gulp.dest('./js/campaigns'));
// });

// gulp.task('watch', ['bundleCSS','bundleJS'], function (){
//   gulp.watch('./sass/campaigns/bottomline/**/*.scss', ['bundleCSS']);
//   gulp.watch('./js/campaigns/bottomline/*.js', ['bundleJS']);
// });

/** Bottomline Landing Page ends **/

/* Bottomline Landing Page starts **/

gulp.task('bundleCSS', function(){
  return gulp.src('./sass/campaigns/elite-deals/elite-deals.scss')
    .pipe(wait(500))
    .pipe(sass(
        {
          'includePaths' : ['./sass/campaigns/elite-deals/'],
          'outputStyle' : 'compressed'
        }
      )
      .on('error', sass.logError)
    )
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('./css/campaigns'))
});

gulp.task('bundleJS', function() {
  return gulp.src([
      './js/campaigns/elite-deals/jquery.js', 
      './js/campaigns/elite-deals/jquery-validation.js',
      './js/campaigns/elite-deals/jquery-additional-methods.js',
      './js/campaigns/elite-deals/slick.js',
      './js/campaigns/elite-deals/main.js'
    ])
    .pipe(wait(500))
    .pipe(concat('elite-deals.js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(terser().on('error', console.error))
    .pipe(gulp.dest('./js/campaigns'));
});

gulp.task('watch', ['bundleCSS','bundleJS'], function (){
  gulp.watch('./sass/campaigns/elite-deals/**/*.scss', ['bundleCSS']);
  gulp.watch('./js/campaigns/elite-deals/*.js', ['bundleJS']);
});

/** Bottomline Landing Page ends **/

