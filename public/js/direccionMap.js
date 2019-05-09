//https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform?hl=es-419


var direccionGoogleMaps = function (){

    var  self = this;
    self.map = null;
    self.radio = null;
    self.inputAddress = 'direccion';
    self.inputLatitud = 'latitud';
    self.inputLongitud = 'longitud';
    self.canvas = 'map_ubicacion';
    self.zoom = 17;
    self.rendermap = true;
    self.cssCanvas = {height:500};
    self.inputRoutePayload = 'route_payload';
    self.comodinstring = '';
    self.configAutocomplete = {types: ['geocode']};

    self.initializeMap = function(latitude, longitude) {

        $('#'+self.canvas).css(self.cssCanvas);


        var LatLng = new google.maps.LatLng( latitude,longitude);

        var mapOptions = {
            zoom: self.zoom,
            center: LatLng,
            panControl: false,
            zoomControl: true,
            scaleControl: true,
            scrollwheel:false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }


        self.map = new google.maps.Map(document.getElementById(self.canvas),mapOptions);


        self.map.setOptions({styles: [
        {
            featureType: "poi.business",
            stylers: [
              { visibility: "off" }
            ]
          }
        ]});


    };

    self.setMarker = function(latitude, longitude){


       var LatLng = new google.maps.LatLng(latitude, longitude);

       var marker = new google.maps.Marker({
           position: LatLng,
           map: self.map,
           title: 'Drag Me!',
           draggable: true
       });

       google.maps.event.addListener(marker, 'dragend', function(marker){
           var latLng = marker.latLng;
           self.setCoor( latLng.lat(),latLng.lng());
       });

       return true;

   };
   
    self.setRadio = function(latitud,longitud,km)
    {
        self.radio = new google.maps.Circle({
        center: new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud)),
        map: self.map,
        strokeColor: '#ee3c39',
        strokeWeight: 2,
        strokeOpacity: 0.5,
        fillColor: '#ee3c39',
        fillOpacity: 0.1,
        radius: km * 1000
        });
        
        
        console.log(latitud,longitud);
    }
  

    self.setCoor = function(lat,lng)
    {
        if($("input[name="+self.inputLatitud+"]"))
        {
          $("input[name="+self.inputLatitud+"]").val(lat);
        }
        if($("input[name="+self.inputLongitud+"]"))
        {
          $("input[name="+self.inputLongitud+"]").val(lng);
        }

        $(document).trigger('change_coords');
    };

    self.getAddress = function(address)
    {
        var geocoder = new google.maps.Geocoder();

        console.log('Dirección Enviada: '+address);

        if(address.length > 0)
        {
            geocoder.geocode({
                address: address,
                // componentRestrictions: {
                //     country : 'MX',
                //     postalCode : cod_pos,
                // },
                }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //centro el mapa en las coordenadas obtenidas
                    console.log(results);

                    self.renderMap(results[0])


                }
                else
                {
                    $('input[name='+self.inputAddress+']').val('');
                    console.log("Error: "+status);
                    _alert("Direccion no encontrada","error");
                }
            });

        }
        return false;
    };


    self.initAutocomplete = function () {

        var autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById(self.inputAddress)),
            self.configAutocomplete
        );

        autocomplete.addListener('place_changed', function() {


            var place = autocomplete.getPlace();

            if (!place.place_id) {

                self.getAddress(place.name);



            }
            else
            {
                $("input[data-address=googlemaps]").each(function(_input,_key)
                {

                    $('input[name='+_input+']').val('');

                });


                self.renderMap(place);
            }

        });


    };



    self.geolocate = function() {

        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function(position) {

            console.log(position);
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            var geocoder = new google.maps.Geocoder;

            var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
                geocoder.geocode({'location': latlng}, function(results, status) {
                    self.renderMap(results[0]);
                    $("input[name="+self.inputAddress+"]").val(results[0].formatted_address);
                    console.log(results);
                });

            });
        }
    };

    self.renderMap = function(results){

        console.log(results);
        for (var i = 0; i < results.address_components.length; i++) {
            var addressType = results.address_components[i].types[0];

            if ($('input[name='+addressType+""+self.comodinstring+']')) {
                var val = results.address_components[i][($('input[name='+addressType+""+self.comodinstring+']').attr('data-format'))];
                $('input[name='+addressType+""+self.comodinstring+']').val(val);
            }
        }


        var latitud = results.geometry.location.lat();
        var longitud = results.geometry.location.lng();

        if(self.rendermap)
        {
          self.initializeMap(latitud,longitud)

          self.setMarker(latitud,longitud);

        }
        self.setCoor(latitud,longitud);
    };




    self.distancia = function(lat_origen,lng_origen,lat_destino,lng_destino,callback)
    {

        if(lat_origen.length > 0 && lng_origen.length > 0 && lat_destino.length > 0 && lng_destino.length > 0)
        {


            var origin1 = {lat: parseFloat(lat_origen), lng: parseFloat(lng_origen)};
            var destination1 = {lat: parseFloat(lat_destino), lng: parseFloat(lng_destino)};

            var service = new google.maps.DistanceMatrixService;
                service.getDistanceMatrix({
                  origins: [origin1],
                  destinations: [destination1],
                  travelMode: 'DRIVING',
                  unitSystem: google.maps.UnitSystem.METRIC,
                  avoidHighways: false,
                  avoidTolls: false
                }, function(response, status) {
                  if (status !== 'OK') {
                    alert('Error was: ' + status);
                  } else {
                    var originList = response.originAddresses;
                    var destinationList = response.destinationAddresses;



                    for (var i = 0; i < originList.length; i++) {
                      var results = response.rows[i].elements;

                      for (var j = 0; j < results.length; j++) {
                          console.log(
                         originList[i] + ' to ' + destinationList[j] +
                            ': ' + results[j].distance.text + ' in ' +
                            results[j].duration.text + '<br>');
                      }
                    }
                    //callback.call()
                  }
              });
        }
    }


    self.direction = function(lat_origen,lng_origen,lat_destino,lng_destino,callback)
    {

        if(lat_origen.length > 0 && lng_origen.length > 0 && lat_destino.length > 0 && lng_destino.length > 0)
        {

            var origin1 = {lat: parseFloat(lat_origen), lng: parseFloat(lng_origen)};
            var destination1 = {lat: parseFloat(lat_destino), lng: parseFloat(lng_destino)};

            var service = new google.maps.DirectionsService;
                service.route({
                  origin: origin1,
                  destination: destination1,
                  travelMode: 'DRIVING',

                }, function(response, status) {
                  if (status !== 'OK') {
                    console.log('Error was: ' + status);
                  } else {

                    console.log(response);
                    $("input[name="+self.inputRoutePayload+"]").val(response.routes[0].overview_polyline);
                    //var directionsDisplay = new google.maps.DirectionsRenderer;
                    //directionsDisplay.setMap(map);

                    //directionsDisplay.setDirections(response);

                    if(typeof(callback) != 'undefined')
                    {
                        callback.call(this,response)
                    }
                }
            });
        }
    }

}
