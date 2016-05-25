
module.exports = function(grunt) {
  require('time-grunt')(grunt);
  grunt.loadNpmTasks('grunt-wiredep');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.initConfig({
    wiredep: {
      cwd: '',
      task: {
        cwd: '',
        src: ['./parts/header.php','./parts/footer.php']
      },
      uglify: {
        cwd: '',
        src: ['./parts/footer.php'],
        options: { compress: true },
        my_target: {
            files: {
              'assets/js/vendor.js': require('wiredep')().js
            }
        }
      },
      cssmin: {
        cwd: '',
        src: ['./parts/header.php'],
        minify: {
            files: {
              'assets/css/vendor.css': require('wiredep')().css
            }
        }
      }

    },

    watch: {
      files: ['bower_components/*'],
      tasks: ['wiredep']
    }
  });

  grunt.registerTask('default', ['wiredep']);
  grunt.registerTask('changes', ['watch']);

};
