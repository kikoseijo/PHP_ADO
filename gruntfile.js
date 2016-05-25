module.exports = function(grunt) {

  grunt.loadNpmTasks('grunt-wiredep');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.initConfig({
    wiredep: {
      task: {
        src: ['./parts/header.php','./parts/footer.php']
      }
    }
  });

  grunt.registerTask('default', ['wiredep']);
};
