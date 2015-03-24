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
            <a href = "index.php"><img src="Logo.jpg" alt = "Agora Home" height = "30px"/></a>                                                        
            <form action = "results.php" id = "locating" class="form-wrapper cf" method = "post">
                <input type="text" placeholder="Enter Location" required id = "location" name = "place">
            </form>   
            <br/>
            <h4 id = "resultnumber"></h4>
            <div id = "results">
                <?php 
                     //Gets place
                    if (isset($_GET['locate'])){
                      $place =  $_GET['locate'];
                      $_GET['locate'] = null;
                    }
                    elseif (isset($_POST['place'])){
                      $place = $_POST['place'];
                    }

                    //Correct UK
                    if(strtolower($place) == "united kingdom"){
                        $kickplace = "Uk";
                    }
                    else if(strtolower($place) == "california"){
                        $kickplace = "CA";
                    }
                    elseif(strtolower($place) == "los angeles"){
                        $kickplace = "LA";
                    }
                    elseif(strtolower($place) == "vermont"){
                        $kickplace = "VT";
                    }   
                    elseif(strtolower($place) == "new york" or strtolower($place) == "new york city"){
                        $kcikplace = "NY";
                    }  
                     elseif(strtolower($place) == "florida"){
                        $kickplace = "FL";
                    }
                    else{
                        $kickplace = $place;
                    }                                                

                    include("simple_html_dom.php");
                ?>
                <div id = "kickstarter">   
                 <br/>
                <?php
                    $kickcounter = 0;
                    $kickstarterdata = file_get_html("https://www.kickstarter.com/projects/search?term=".rawurlencode($kickplace));
                        foreach($kickstarterdata -> find('div[class=project-card project-card-tall]') as $project){
                            foreach ($project -> find('div[class=project-card-content]') as $fortitle){

                                $isfunded = $project -> find('div[class="project-pledged-successful"]');
                                $isfunded = $isfunded -> innertext;

                                foreach ($fortitle -> find('a') as $link){
                                    $title = $link -> innertext;
                                    $link = "https://www.kickstarter.com" . $link -> href;
                                }

                                if((strpos($title,"Canceled") === false ) and (strpos($title,"Suspended") === false)){
                                    $nextcheck = true;
                                }else{
                                    $nextcheck = false;
                                }

                                //Check if located there
                                foreach($project -> find('span[class="location-name"]') as $plocate){
                                    $location = $plocate -> innertext;
                                }
                                $testval =  strstr(strtolower($location), strtolower($kickplace));

                             if(($isfunded !== "Successfully funded!") and ($testval != null) and ($nextcheck === true)){

                                $isnotsuccess = $project -> find('div[class="project-status project-failed"]',0);                             

                                if ($isnotsuccess === null){
                                    $kickcounter += 1;
                                    //echo title
                                    echo "<div style='color:white';'font-size:20px';><a href=".$link." target='_blank';>".$title."</a></div>";
                                

                                foreach($project -> find('p[class="project-byline"]') as $pauthor){
                                    $author = $pauthor -> innertext;
                                    echo '<span style="font-size:11px">by '.htmlentities($author).'</span><br />';
                                }

                                foreach($project -> find('p[class="project-blurb"]') as $pdescribe){
                                    $description = $pdescribe -> innertext;
                                    echo '<span style="font-size:14px">'.htmlentities($description).'</span><br/>';
                                }

                                foreach($project -> find('span[class="money usd no-code"]') as $pamount){
                                    $amountraised = $pamount -> innertext;
                                    echo '<span style="font-size:14px"><span style="color:#238EC4";>'.htmlentities($amountraised)." Raised</span></span><br />";
                                }

                                if ($project -> find('span[class="money usd no-code"]') == null){
                                    foreach($project -> find('span[class="money cad no-code"]') as $newamount){
                                     $amountraised = $newamount -> innertext;
                                     echo '<span style="font-size:14px"><span style="color:#238EC4";>'.$amountraised." Raised</span></span><br />";                                       
                                    }
                                }
                                if (($project -> find('span[class="money cad no-code"]') == null) and ($project -> find('span[class="money usd no-code"]') == null)){
                                    foreach($project -> find('span[class="money eur no-code"]') as $newamount2){
                                     $amountraised = $newamount2 -> innertext;
                                     echo '<span style="font-size:14px"><span style="color:#238EC4";>'.htmlentities($amountraised)." Raised</span></span><br />";                                       
                                    }
                                }  

                                if (($project -> find('span[class="money cad no-code"]') == null) and ($project -> find('span[class="money usd no-code"]') == null) and ($project -> find('span[class="money usd no-code"]') == null)){
                                    foreach($project -> find('span[class="money sek no-code"]') as $newamount2){
                                     $amountraised = $newamount2 -> innertext;
                                     echo '<span style="font-size:14px"><span style="color:#238EC4";>'.htmlentities($amountraised)." Raised</span></span><br />";   
                                     $test = true;                                    
                                    }                                    
                                }
                                if($test !== true){
                                     foreach($project -> find('span[class="money gbp no-code"]') as $newamount2){
                                     $amountraised = $newamount2 -> innertext;
                                     echo '<span style="font-size:14px"><span style="color:#238EC4";>'.htmlentities($amountraised)." Raised</span></span><br />";                                       
                                    }                                   
                                }


                                foreach($project -> find('div[class="project-stats-value"]') as $ppercent){
                                 if($ppercent -> innertext !== "Funded"){ 
                                    $spantest = $ppercent -> find('span[class="money usd no-code"]');
                                    $spantest2 = $ppercent -> find('span[class="project-stats-label"]');
                                    if($spantest[0] === null and $spantest2[0] !== "funded"){
                                        $percentraised = $ppercent -> innertext;
                                        echo '<span style="font-size:14px">'.$percentraised." of Goal</span><br/><br/>";
                                        break;
                                    }
                                  }
                                }
                                //Echo location if needed
                                //echo '<span style="font-size:11px">located in <span style="color:#66B19C">'.$location.'</span></span><br/><br/>';
                              }
                            }
                            }
                        } 
                ?> 
                </div>
                <div id ="indiegogo">
                    <?php
                        $indiecounter = 0;
                        $indiegogodata = file_get_html("https://www.indiegogo.com/explore?utf8=✓&filter_city=".rawurlencode($place)."&filter_country=&filter_quick=&filter_title=".rawurlencode($place)."&filter_category=&fetch_count=12&scroll_top=703&commit=Submit&filter_percent_funded=&filter_status=&filter_funding=");


                        foreach(($indiegogodata -> find('div[class="i-project-card"]')) as $project){

                            foreach($project -> find('div[class="i-time-left"]') as $time){
                                $testtime = $time -> innertext;
                                echo $testtime === "O time left";
                                if(strpos($testtime,"0 time left") === false){
                                    $timeleft = true; 
                                }else{
                                    $timeleft = false;
                                }
                            }
 
                            foreach($project -> find('a[class="i-project"]') as $plink){
                                $link = "https://www.indiegogo.com/".$plink -> href;
                            }

                            //location test
                            $islocated = file_get_html($link);
                            foreach($islocated -> find('a[class="i-byline-location-link"]') as $totest){
                                $checkplace = $totest -> innertext;

                                if(strpos(strtolower($checkplace), strtolower($place)) === false){
                                    $isinlocation = false;
                                }else{
                                    $isinlocation = true;
                                }

                            } 


                          if(($timeleft === true) and ($isinlocation === true)){  

                            foreach($project -> find('div[class="i-title"]') as $ptitle){
                                $indiecounter += 1;                                
                                $title = $ptitle -> innertext;
                                echo "<div style='color:white';'font-size:20px';><a href=".$link." target='_blank';><br/>".$title."</a></div>";
                            }

                            foreach($project -> find('div[class="i-tagline"]') as $pdescribe){
                                $description = $pdescribe -> innertext;
                                echo '<span style="font-size:14px">'.htmlentities($description).'</span><br/>';
                            }

                            foreach($project -> find('span[class="currency currency-medium"]') as $pamount){

                                foreach($pamount -> find('span') as $span){
                                    $amountraised = $span -> innertext;
                                     echo '<span style="font-size:14px"><span style="color:#238EC4";>'.htmlentities($amountraised)." Raised</span></span><br />";                                       
                                    
                                }
                            }

                            foreach($project -> find('div[class="i-percent"]') as $ppercent){
                                $percentraised = $ppercent -> innertext;
                                echo '<span style="font-size:14px">'.$percentraised." of Goal</span>";
                            }
                           }                                                        
                        }                       
                    ?>
                    <script>
                    var tosay = <?php
                        if(($kickcounter == 0) and ($indiecounter == 0)){
                            echo json_encode("<br/>No active projects in {$place}<br/>Search another location?");
                        }else{
                         $disp = $kickcounter + $indiecounter;
                          if($disp > 1){
                                echo json_encode("<br/><b>{$disp} Projects Found</b>");
                            }else if($disp === 0){
                                echo json_encode("<br/><b>No projects Found.</b>");
                              }else if($disp === 1){
                                 echo json_encode("<br/><b>1 project Found.</b>");
                               }  
                         }                      
                    ?>;
                        document.getElementById("resultnumber").innerHTML =  tosay;
                    </script>
                </div>    
            </div>    
        </section>    
        
        <div id = "content">            
        </div>
    </body>
</html>

<script>
$(document).ready(function(){
    
L.mapbox.accessToken =  'pk.eyJ1IjoiemFnaGllIiwiYSI6IjVuY3ZCOGcifQ.l1MXAPvGBjI-8YtXtg-h6g';
map =L.mapbox.map('content','zaghie.lb30h898');        
geocode = L.mapbox.geocoder('mapbox.places');
myLayer = L.mapbox.featureLayer().addTo(map);    
    
//When Loaded
place = localStorage.getItem("place");
if (place != null){    
    document.getElementById('location').value = place;       
    geocode.query(place,showMap);    
    event.preventDefault();
    event.stopPropagation();                  
    localStorage.removeItem('place');
}
    
//When location pressed
 document.getElementById('location').onkeydown = function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        var place = $('#location').val(); 
        localStorage.setItem("place",place); 
        document.getElementById("locating").submit();
        document.getElementById("resultnumber").innerHTML ="";
        document.getElementById("kickstarter").innerHTML = "";
        document.getElementById("indiegogo").innerHTML = "";        
        geocode.query(place,showMap);                
        event.preventDefault();
        event.stopPropagation();           
    }
   };
        

//Shows Location on map
    function showMap(err, data){
        if (data.lbounds){
            map.fitBounds(data.lbounds);
        }
        else if (data.latlng){
            map.setView([data.latlng[0],data.latlng[1]],13);
        }
    }    

});
</script>

 