$(document).ready(function(){    
  //Configure MapBox
    L.mapbox.accessToken = 'pk.eyJ1IjoiemFnaGllIiwiYSI6IjVuY3ZCOGcifQ.l1MXAPvGBjI-8YtXtg-h6g';
    map =L.mapbox.map('content','zaghie.lb30h898');  
    geocode = L.mapbox.geocoder('mapbox.places');
    myLayer = L.mapbox.featureLayer().addTo(map);
    //Get Location Value when Enter pressed
    document.getElementById('location').onkeydown = function(event) {
        if (event.keyCode == 13) {
            var place = document.getElementById('location').value;
            document.getElementById('location').value = "";            
            event.preventDefault();
            event.stopPropagation();
            localStorage.setItem("place", place);
            window.location.href = "results.php?locate="+place;
       }
   }  
});

    function showMap(err, data){
        if (data.lbounds){
            map.fitBounds(data.lbounds);
        }
        else if (data.latlng){
            map.setView([data.latlng[0],data.latlng[1]],13);
        }
    }   

