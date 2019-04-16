/* 
 * Ussiel Acevedo
 * 24 Agosto 2015
 * 
<div id="map-canvas" style="width: 100%; height: 500px;"></div>
<script >
<!--
    function initMap()
    {
        map =  new google_maps();
        map.initialize("map-canvas",<?php echo $MyConfigureGoogleMaps->getLatitud(); ?>,<?php echo $MyConfigureGoogleMaps->getLongitud(); ?>);
        map.marker_options = { 
            html: "<h3>mi ubicacion</h3>", 
            title: "mi ubicacion",
            draggable: true,
            //evento_callback: {funcion: alerta, evento: "click" }, //dragend,click
            icon: { 
                url: "<?php echo getImg('mark.png') ?>",
                width: 32,
                height: 32,
            }
        };
        
        map.setMarker(<?php echo $MyConfigureGoogleMaps->getLatitud(); ?>,<?php echo $MyConfigureGoogleMaps->getLongitud(); ?>);
    }
-->
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $MyConfigureGoogleMaps->getKey(); ?>&callback=initMap" async defer></script>

Other Configs

map.markerCluster_options = {gridSize: 50, maxZoom: 16, 
        styles: [{
            url: '/img/marcadores-mapa/marcador-gratuito.png',
            height: 55,
            width: 35,
            anchor: [0, 0],
            textColor: '#000000',
            textSize: 10
        }]};

map.setMarker("17.414239","-98.173165");
map.setMarkerCluster();
map.setKm(.2)
map.setRadio("17.414239","-98.173165");
map.deleteMarkers();
*/



var google_maps = function (){
    
    var  self = this;
    self.map = null;
    self.markers = [];
    self.marker_options = {};
    self.markerCluster = null;
    self.markerCluster_options = {};
    self.km = .5;
   
    
    self.initialize = function(canvas,latitud,longitud)
    {
        var mapOptions = {
            zoom: 17,
            center: {lat: latitud, lng: longitud}
        }
        self.map = new google.maps.Map(document.getElementById(canvas),
                                      mapOptions);
    };
    
  
    self.setCenter = function(latitud,longitud)
    {
        
        self.map.setCenter({lat: latitud, lng: longitud});
    }
   
    self.setMarker = function(latitud,longitud,open)
    {
        var option = {
            position: {lat: latitud, lng: longitud},
            map: self.map,
            icon:{},
            title: "",
            draggable : false
        };
        
        if(self.marker_options.icon)
        {
            
            option.icon.url = self.marker_options.icon.url;
            option.icon.size = new google.maps.Size(self.marker_options.icon.width, self.marker_options.icon.height);
            option.icon.origin = new  google.maps.Point(0,0);
            option.icon.anchor = new google.maps.Point(0, self.marker_options.icon.height);
                        
        }
        if(self.marker_options.title)
        {
            option.title = self.marker_options.title;
        }
        if(self.marker_options.draggable)
        {
            option.draggable = self.marker_options.draggable;
        }
        
        var marker = new google.maps.Marker(option);
        
        if(self.marker_options.html)
        {
            var infoWindow = new google.maps.InfoWindow({maxWidth: 200});
            self.bindInfoWindow(marker, self.map,infoWindow, self.marker_options.html);
            
            if(self.marker_options.open)
            {
                 infoWindow.setContent(self.marker_options.html);
                 infoWindow.open(self.map,marker);
            }
        }
        
        if(self.marker_options.evento_callback)
        {
            geocoder = new google.maps.Geocoder();

            google.maps.event.addListener(marker, self.marker_options.evento_callback.evento, function() {

                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK)
                    {
                        fx = self.marker_options.evento_callback.funcion;
                        fx(self.marker_options.title,marker.getPosition(), results);
                    }


                });

            });
        }
        self.markers.push(marker);
    }
    
    self.bindInfoWindow = function(marker, map, infoWindow, html) 
    {
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
    }
    
   self.deleteMarkers = function() {
        for (var i = 0; i < self.markers.length; i++)
        {
            self.markers[i].setMap(null);
        }
        self.markers = [];
        
        if(self.markerCluster != null)
        {
            self.markerCluster.clearMarkers();
        }
    }
    
    self.setMarkerCluster = function()
    {
         self.markerCluster = new MarkerClusterer(self.map, self.markers,self.markerCluster_options);
    }
    
    self.setKm = function(km)
    {
        self.km = km;
    }
    
    self.setZoom = function(zoom)
    {
        self.map.setZoom(zoom); 
    }
    
    self.setRadio = function(latitud,longitud)
    {
        var radio = new google.maps.Circle({
        center: new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud)),
        map: self.map,
        strokeColor: '#ee3c39',
        strokeWeight: 2,
        strokeOpacity: 0.5,
        fillColor: '#ee3c39',
        fillOpacity: 0.1,
        radius: self.km * 1000
        });
        
        self.markers.push(radio);
        
    }
    
    self.rad = function(x) {return x*Math.PI/180;}
    
    self.distancia = function(lat1, lon1, lat2, lon2)
    {
        

        var R     = 6378.137;                          //Radio de la tierra en km
        var dLat  = self.rad( lat2 - lat1 );
        var dLong = self.rad( lon2 - lon1 );

        var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(self.rad(lat1)) * Math.cos(self.rad(lat2)) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;

        return d.toFixed(3);                      //Retorna tres decimales
    }
};