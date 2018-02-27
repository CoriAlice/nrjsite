<div id="map"> </div>


      <script>
      var map;
      var infowindow = null;
      
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 47, lng: 2},
          zoom: 5
        });
      
        var locxjson=<?php echo json_encode($locx)?>;
  //var locxjs=JSON.parse(locxjson);
  
        var locyjson=<?php echo json_encode($locy)?>;
    
        var typejson=<?php echo json_encode($type)?>;
        var namejson=<?php echo json_encode($name)?>;
        var stockjson=<?php echo json_encode($stock)?>;
        

        var marker;
        var label;
        var content;
        
        infowindow = new google.maps.InfoWindow({
        content: "holding..."
        });
        
        for (var iter = 0; iter <locxjson.length; iter++) {
 
    var location ={lat: locxjson[iter], lng: locyjson[iter]};
    
    
    if (typejson[iter]=='consumer') label = 'C' ;
     if (typejson[iter]=='producer') label = 'P' ;
     
     content = '<h3>'+namejson[iter]+'</h3>'+'<p>Nombre de stocks : '+stockjson[iter]+'</p>';
     
    
    marker = new google.maps.Marker({
        position: location,
        label : label,
        map: map,
        html : content
        });   
        
     google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(this.html);
        infowindow.open(map, this);
        }); 

}


      }
      
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAah0iyDxXAeh547oc6VgOW1myVG_h_cGA&callback=initMap"
    async defer></script>

    