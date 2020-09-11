

<?php
/**
 * Plugin Name: MapsLayers
 * Plugin URI: none
 * Description: Providing corelation between Maps and database
 * Version: 1.0
 * Author: Lilian
 * Author URI: none
 */
 
 


function vsg_maps_shortcode($atts, $content = null) {

$servername = "localhost";
$username = "wp-user";
$password = "leoed";
 
$conn = mysqli_connect($servername, $username, $password, "wordpress");
 
if($conn === false) {
	die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM wordpress.wp_wpgmza;";
$result = mysqli_query($conn, $sql);


if(!$result) {
	die('Invalid query: '. mysql_error());
}




    extract(shortcode_atts(array(
    "align" => 'left',
    "width" => '100',
    "height" => '380',
    "address" => '',
	"info_window" => 'A',
	"zoom" => '14',
	"companycode" => '',
	"maptype" => 'm'
    ), $atts));
	
	
	 $jscript = '
	    <style>   
	      #map {
		height: '.$height.'px; 
		width: '.$width.'%;  
	       }
	    </style>
	    
	    <div id="map" class="vsg-map" align="'.$aling.'"></div>
	    
	    <script>
		function initMap() {
		  var sofia = {lat: 42.697863, lng: 23.322179};
		  var map = new google.maps.Map(document.getElementById(\'map\'), {zoom: '.$zoom.', center: sofia});
		  var marker = new google.maps.Marker({position: sofia, map: map});
		}

	    </script>
	    <script defer
	    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbMXzvkDi2QnjeYR0JDSd3GAQVdw4MSKY&callback=initMap">
	    </script>';
	    
	if(mysqli_num_rows($result) > 0) {
		
		while($row = mysqli_fetch_array($result)) {
			 echo('
				
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbMXzvkDi2QnjeYR0JDSd3GAQVdw4MSKY">
			function addMarker(location, map) {
				var marker = new google.maps.Marker({
				position: location,
				map: map});
			};
			
			var location = {lat: '.floatval($row["lat"]).', lng: '.floatval($row["lng"]).'};
			
			addMarker(location, document.getElementById(\'map\'));
			
			</script>');
  		}
		
		mysqli_free_result($result);
	}
	mysqli_close($conn);
	
	return $jscript;
	
}
    
        
add_shortcode("vsgmap", "vsg_maps_shortcode");
?>


