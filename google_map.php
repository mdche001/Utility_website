<?php /* Template Name: google_map */ ?>
<?php get_header(); ?>

<?
$googleKey = "AIzaSyBpYdHJXDsByckC1aeA8MThdLsGaVIh9AI";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
 	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
    </style>
   <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<?echo $googleKey?>&sensor=true"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  </head>
  <body onload="initializeMap()">
	<form action="/" id="searchForm">
		<input type="text" name="s" placeholder="Search..." />
		<input type="submit" value="Search" />
	</form>	  
	<div id="result"></div>  	
	<div id="map_canvas" style="width:50%; height:50%"></div>
	<br />
	<div class="coordinates"></div>
	
    <script type="text/javascript">
		var marker;
		var map;
		var googleKey = "AIzaSyBpYdHJXDsByckC1aeA8MThdLsGaVIh9AI";
		var geocoder = new google.maps.Geocoder();
		xPos = 0;
		yPos = 0;
		address = '';
	
      $("#searchForm").submit(function(event) {	
		    event.preventDefault(); 		        
		    var $form = $(this),
		        term = $form.find( 'input[name="s"]' ).val(),
		        $content = $('#result');
		        $coordinates = $('.coordinates');
		        url = "getdata.php";
		    var resultArray = [];
		    
		    $.getJSON("getdata.php",
			  {s: term,},
			  function(data) {			  
			  	// wenn mehr als 1 Eintrag vorhanden
			  	if(data.results.length >1){			  	
			  		$content.html('Es gibt mehrere Einträge zu dieser Postleitzahl, bitte wählen sie aus');
			  		$content.append('<ul class="list">');			  		
			  			  		
				    $.each(data.results, function(i,item){				    	
				    	$('#result .list').append('<li><a href="" data="'+i+'">'+item.formatted_address);	
				    	resultArray[i] = item.geometry.location;
				    });
				    
					$('#result .list li a').bind('click', function(e) {
						e.preventDefault();
			  			var data = $(this).attr('data');	
			  			xPos = resultArray[data].lat;
			  			yPos = resultArray[data].lng;
			  			initializeMap();
					});
			   	}else {			   		
			   		$.each(data.results, function(i,item){		
			   			$content.html(item.formatted_address);			   					    	
				    	xPos = item.geometry.location.lat;
		  				yPos = item.geometry.location.lng;
		  				address = item.formatted_address;
		  				initializeMap();
				    });				   
			   		
			   	}
			   	$coordinates.html('xPos: ' + xPos +' / yPos: '+yPos)
			   	
			   
			  })
			  
	    });
	    
	    
	    function geocodePosition(pos) {
            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                	//console.log(responses[0].geometry.location);
                	$coordinates.html('xPos: ' + responses[0].geometry.location.Xa +' / yPos: '+responses[0].geometry.location.Ya)
                    //updateMarkerAddress(responses[0].formatted_address);
                } else {
                    console.log('Cannot determine address at this location.');
                }
            });
        }
	    
	    
	    function initializeMap() {		    	
			  	var myLatlng = new google.maps.LatLng(xPos, yPos);   			  	
				var myOptions = {
				  center: myLatlng,
				  zoom: 10,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				};				        
				var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
				var marker = new google.maps.Marker({
					position: myLatlng,
				  	map: map,
				  	draggable: true,
				  	title: address,
				  	icon: 'factory.png'
				});
				
				google.maps.event.addListener(marker, 'dragend', function() { 
				 	geocodePosition(marker.getPosition());
				}); 
				
		}
		
	    
    </script>	  
  </body>
</html>

<div class="col-md-12">
	<div class="left-content" >
	<?php
	while( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );
		
		comments_template();
		
	endwhile;
	?>

	</div>
</div>
<?php get_footer(); ?>