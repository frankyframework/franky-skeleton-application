module.exports = function(grunt) {
  require('jit-grunt')(grunt);

  grunt.initConfig({
    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: { // destination file and source file
          "public/skin/default/css/style.css": "public/skin/default/less/style.less", "public/skin/default/css/grid.css": "public/skin/default/less/grid.less", "public/skin/default/css/panel.css": "public/skin/default/less/panel.less", "public/skin/ecommerce/css/cart.css": "public/skin/ecommerce/less/cart.less",
        }
      }
    },
    watch: {
      less: {
            files: ['public/skin/default/less/*.less', 'public/skin/ecommerce/less/*.less'],
            tasks: ['less'],
            options: {
                livereload: true
            }
        }
    }
  });

  grunt.registerTask('default', ['less', 'watch']);
};
