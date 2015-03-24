<!DOCTYPE html>
<html>
    <head>
<link rel="shortcut icon" href="Favicon.ico"/>              
        <title>Agora</title>  
         <link rel="stylesheet" type="text/css" href="stylesheet.css">
       <script src='https://api.tiles.mapbox.com/mapbox.js/v2.1.4/mapbox.js'></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
        <link href='https://api.tiles.mapbox.com/mapbox.js/v2.1.4/mapbox.css' rel='stylesheet' />
    </head>

    <body>
        <section id ="intro" class ="section">
            <div class="introContent">
             <img src="Logo.jpg" alt="AGORA" style="width:304px;height:80px">
            <p class="description">Find crowdfunding projects in your area</p>
            <form class="form-wrapper cf">
                <input type="text" placeholder="Enter a Location" required id = "location" name = "location">
            </form>   
            </div>
        </section>    
        
        <div id = "content">
        </div>
    </body>
</html>    
<script>
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
            window.location.href = "./results.php?locate="+place;
       }
   }
</script>