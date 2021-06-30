module.exports = function(grunt) {
  require('jit-grunt')(grunt);

  grunt.initConfig({
    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          sourceMap: true,
          optimization: 2
        },
        files: { // destination file and source file
            "modulos/base/web/theme1/css/style.css": "modulos/base/web/theme1/less/style.less",
            "modulos/base/web/default/css/style.css": "modulos/base/web/base/less/style.less",
          "modulos/base/web/base/css/style.css": "modulos/base/web/base/less/style.less",
          "modulos/base/web/base/css/grid.css": "modulos/base/web/base/less/grid.less", 
          "modulos/base/web/base/css/panel.css": "modulos/base/web/base/less/panel.less", 
          "modulos/ecommerce/web/css/cart.css": "modulos/ecommerce/web/less/cart.less", 
          "modulos/catalog/web/css/catalog.css": "modulos/catalog/web/less/catalog.less", 
          "modulos/blog/web/css/blog.css": "modulos/blog/web/less/blog.less", 
          "modulos/sliders/web/css/sliders.css": "modulos/sliders/web/less/sliders.less",
        }
      }
    },
    watch: {
      less: {
            files: [
            'modulos/base/web/base/less/*.less', 
            'modulos/base/web/default/less/*.less', 
            'modulos/base/web/theme1/less/*.less', 
            'modulos/ecommerce/web/less/*.less', 
            'modulos/catalog/web/less/*.less', 
            'modulos/blog/web/less/*.less', 
            'modulos/sliders/web/less/*.less'],
            tasks: ['less'],
            options: {
                livereload: true
            }
        }
    },
      browserSync: {
          dev: {
              bsFiles: {
                  src: [
                      'modulos/base/web/base/css/*.css',
                      'modulos/base/web/default/css/*.css',
                      'modulos/base/web/theme1/css/*.css',
                      'modulos/base/web/base/css/franky-font/*.css',
                      'modulos/catalog/web/css/*.css',
                      'modulos/ecommerce/web/css/*.css',
                      'modulos/blog/web/css/*.css',
                      'modulos/galeria/web/css/*.css',
                      'modulos/slider/web/css/*.css',
                      'modulos/base/diseno/*.phtml'
                  ]
              },
              options: {
                  watchTask: true,
                  proxy: "local.franky"
              }
          }
      }
  });
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.registerTask('default', ['less', 'browserSync', 'watch']);
};
