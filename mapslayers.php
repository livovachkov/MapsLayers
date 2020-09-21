
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
	"maptype" => 'm',
    "readdb" => '1'
    ), $atts));
	
	
	 $jscript = '
	    <style>   
	      #map {
		height: '.$height.'px; 
		width: '.$width.'%;  
	       }
	    </style>
	    
	    <div id="map" class="vsg-map" align=".aling."></div>';
    echo($jscript);
    if($readdb == 1) {
        $jscript2 = '<script src="http://localhost/blog/wp-content/plugins/MapsLayers/script.js" type="text/javascript"></script><script type="text/javascript">window.onload=function() { var location; var i = 0;';
        if(mysqli_num_rows($result) > 0) {
            
            while($row = mysqli_fetch_array($result)) {
                //$jscript2 .= 'location = new google.maps.LatLng('.floatval($row["lat"]).', '.floatval($row["lng"]).'); addMarker(location, document.getElementById("map"));';
                $jscript2 .= 'location = {lat: parseFloat('.$row["lat"].'), lng: parseFloat('.$row["lng"].')};var mark = []; mark[i] = addMarker(location, document.getElementById(\'map\'));';
            }
            $jscript2 .= '};</script>';
            mysqli_free_result($result);
        }
        mysqli_close($conn);
        
        return $jscript2;
	}

}
    
        
add_shortcode("vsgmap", "vsg_maps_shortcode");
?>
