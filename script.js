


            
        var script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAbMXzvkDi2QnjeYR0JDSd3GAQVdw4MSKY&callback=initMap';
        script.defer = true;

        
        
        window.initMap = function() {
		    var sofia = {lat: 42.697863, lng: 23.322179};
		    var map = new google.maps.Map(document.getElementById('map'), {zoom: 14, center: sofia});
		    var marker = new google.maps.Marker({position: sofia, map: map});
		
          var pos = {lat: 42.682333, lng: 23.367722};
          //var marker2 = new google.maps.Marker({position: pos, map: map});
          //addMarker(pos, map);
        };

// Append the 'script' element to 'head'
        document.head.appendChild(script);

        function addMarker(location, map) {
            
				var marker = new google.maps.Marker({
				position: location,
                optimized: false,
				setMap: map});
                
                return marker;
        };

        
