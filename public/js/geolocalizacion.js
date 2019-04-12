/* 
 * Ussiel Acevedo.
 * 24 Agosto 2015
 * geo =  new geolocalizacion();
 * geo.setFuncion(function);
 * geo.geo_actual(); geo.geo_recurrente();
 */


var geolocalizacion = function (){
    
    var  self = this;
    self.latitud='';
    self.longitud =''
    self.watchID = null;
    self.funciones = [];
    
    self.execute = function()
    {
        for(var i=0; i < self.funciones.length; i++)
        {
            var fx = self.funciones[i]
            fx(self.latitud,self.longitud);
        }
    };
            
    self.setFuncion = function(fx)
    {
        self.funciones.push(fx);
    };
    
    self.geo_recurrente = function()
    {
        if (navigator.geolocation)
        {
                self.watchID = navigator.geolocation.watchPosition(geo_cooredenadas, function(){}, {
                                                enableHighAccuracy: true, 
                                                maximumAge        : 30000, 
                                                timeout           : 27000
                                            });
        }
    }; 
    
    self.stop_geo_recurrente = function()
    {
         navigator.geolocation.clearWatch(self.watchID);
    };
    
    self.geo_actual = function()
    {
        
        if (navigator.geolocation)
        {
                navigator.geolocation.getCurrentPosition(geo_cooredenadas);
        }
    };
    
    function geo_cooredenadas(position)
    {
        
        self.latitud = position.coords.latitude;
        self.longitud = position.coords.longitude;
        
        self.execute(); 
        
    };
    
   
};