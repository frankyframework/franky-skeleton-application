
var GuillotineBlog = function() {

      $("#content_guillotina").show();
      var picture = $('#imgpreview');

      picture.guillotine('remove');
      // Make sure the image is completely loaded before calling the plugin
      picture.one('load', function(){
      // Initialize plugin (with custom event)
      picture.guillotine({width: 1500, height: 750, eventOnChange: 'guillotinechange'});
      // Display inital data
      var data = picture.guillotine('getData');
      data.scale = parseFloat(data.scale.toFixed(4));
      var _data = JSON.stringify(data);
      $("input[name=data_img]").val(_data);
      //  for(var key in data) { $('#'+key).html(data[key]); }
      // Bind button actions
      $('#rotate_left').click(function(){ picture.guillotine('rotateLeft'); });
      $('#rotate_right').click(function(){ picture.guillotine('rotateRight'); });
      $('#fit').click(function(){ picture.guillotine('fit'); });
      $('#zoom_in').click(function(){ picture.guillotine('zoomIn'); });
      $('#zoom_out').click(function(){ picture.guillotine('zoomOut'); });
      // Update data on change
      picture.on('guillotinechange', function(ev, data, action) {
          data.scale = parseFloat(data.scale.toFixed(4));
          var _data = JSON.stringify(data);
          $("input[name=data_img]").val(_data);
          /*
          for(var k in data) {
              $('#'+k).html(data[k]);
          }
          */
          });
      });
      // Make sure the 'load' event is triggered at least once (for cached images)
     if (picture.prop('complete')) picture.trigger('load')
}
