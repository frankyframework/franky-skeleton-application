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
          "public/skin/default/css/style.css": "public/skin/default/less/style.less", "public/skin/default/css/grid.css": "public/skin/default/less/grid.less", "public/skin/default/css/panel.css": "public/skin/default/less/panel.less", "public/skin/ecommerce/css/cart.css": "public/skin/ecommerce/less/cart.less","public/skin/default/css/style_base.css": "public/skin/default/less/style_base.less",
         // "public/skin/intelytrade/css/style.css": "public/skin/intelytrade/less/style.less", "public/skin/intelytrade/css/grid.css": "public/skin/intelytrade/less/grid.less",
          //"public/skin/parrilladas/css/style.css": "public/skin/parrilladas/less/style.less", "public/skin/parrilladas/css/grid.css": "public/skin/parrilladas/less/grid.less",
          //"public/skin/lamatmexico/css/style.css": "public/skin/lamatmexico/less/style.less", "public/skin/lamatmexico/css/grid.css": "public/skin/lamatmexico/less/grid.less",
          "public/skin/meteoro/css/style.css": "public/skin/meteoro/less/style.less", "public/skin/meteoro/css/grid.css": "public/skin/meteoro/less/grid.less",
          "public/skin/mubbmi/css/style.css": "public/skin/mubbmi/less/style.less", "public/skin/mubbmi/css/grid.css": "public/skin/mubbmi/less/grid.less", "public/skin/mubbmi/css/panel_extended.css": "public/skin/mubbmi/less/panel_extended.less",
          "public/skin/tecamac/css/style.css": "public/skin/tecamac/less/style.less", "public/skin/tecamac/css/grid.css": "public/skin/tecamac/less/grid.less", "public/skin/tecamac/css/panel_extended.css": "public/skin/tecamac/less/panel_extended.less",
          "public/skin/bingoo/css/style.css": "public/skin/bingoo/less/style.less", "public/skin/bingoo/css/grid.css": "public/skin/bingoo/less/grid.less", "public/skin/bingoo/css/panel_extended.css": "public/skin/bingoo/less/panel_extended.less",
          "public/skin/walkmodels/css/style.css": "public/skin/walkmodels/less/style.less", "public/skin/walkmodels/css/grid.css": "public/skin/walkmodels/less/grid.less", "public/skin/walkmodels/css/panel_extended.css": "public/skin/walkmodels/less/panel_extended.less",
          "public/skin/inteligenciacanina/css/style.css": "public/skin/inteligenciacanina/less/style.less", "public/skin/inteligenciacanina/css/grid.css": "public/skin/inteligenciacanina/less/grid.less", "public/skin/inteligenciacanina/css/panel_extended.css": "public/skin/inteligenciacanina/less/panel_extended.less",
          //"public/skin/modellico/css/style.css": "public/skin/modellico/less/style.less", "public/skin/modellico/css/grid.css": "public/skin/modellico/less/grid.less", "public/skin/inteligenciacanina/css/panel_extended.css": "public/skin/inteligenciacanina/less/panel_extended.less",
          "public/skin/ubiflow/css/style.css": "public/skin/ubiflow/less/style.less", "public/skin/ubiflow/css/grid.css": "public/skin/ubiflow/less/grid.less", "public/skin/ubiflow/css/panel_extended.css": "public/skin/ubiflow/less/panel_extended.less",
          "public/skin/caribecooler/css/style.css": "public/skin/caribecooler/less/style.less", "public/skin/caribecooler/css/grid.css": "public/skin/caribecooler/less/grid.less", "public/skin/caribecooler/css/panel_extended.css": "public/skin/caribecooler/less/panel_extended.less",
          "public/skin/mercarancho/css/style.css": "public/skin/mercarancho/less/style.less", "public/skin/mercarancho/css/grid.css": "public/skin/mercarancho/less/grid.less", "public/skin/mercarancho/css/panel_extended.css": "public/skin/mercarancho/less/panel_extended.less"
        }
      }
    },
    watch: {
      less: {
            files: ['public/skin/default/less/*.less', 'public/skin/meteoro/less/*.less', 'public/skin/inteligenciacanina/less/*.less', 'public/skin/mubbmi/less/*.less', 'public/skin/mercarancho/less/*.less', 'public/skin/ubiflow/less/*.less', 'public/skin/caribecooler/less/*.less', 'public/skin/tecamac/less/*.less', 'public/skin/bingoo/less/*.less', 'public/skin/walkmodels/less/*.less', 'public/skin/ecommerce/less/*.less'],
            tasks: ['less'],
            options: {
                livereload: true
            }
        }
    }
  });

  grunt.registerTask('default', ['less', 'watch']);
};
