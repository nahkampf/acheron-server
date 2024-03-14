<?php
require "../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();
?>
<!DOCTYPE html>
<!--
     @license
     Copyright 2019 Google LLC. All Rights Reserved.
     SPDX-License-Identifier: Apache-2.0
    -->
<html>

<head>
	<title>Acheron Map Interface</title>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<style>
		/**
 * @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */
		/* 
 * Always set the map height explicitly to define the size of the div element
 * that contains the map. 
 */
		#map {
			height: 100%;
		}

		/* 
 * Optional: Makes the sample page fill the window. 
 */
		html,
		body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
	</style>
</head>

<body>
	<div id="map"></div>
</body>
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOiZWa9lT5fR3T5fSLLALNmyfmv18cs7I&callback=initMap&v=weekly&libraries=geometry"
	async defer>
</script>
<script>
	let map;

	function initMap() {} // now it IS a function and it is in global


	const acheron_base = {
		lat: 52.59905927193015,
		lng: 13.744135878074324
	};

	function createCenterControl(map) {
		const controlButton = document.createElement("button");

		// Set CSS for the control.
		controlButton.classList.add('buttonStyle');

		controlButton.textContent = "Center Map";
		controlButton.title = "Click to recenter the map";
		controlButton.type = "button";
		// Setup the click event listeners: simply set the map to Chicago.
		controlButton.addEventListener("click", () => {
			map.setCenter(acheron_base);
		});
		return controlButton;
	}

	function initMap() {

		const MAP_BOUNDS = {
			north: 52.651284744285135266,
			south: 52.536569560706845,
			west: 13.589778740039401,
			east: 13.905509501535349,
		};

		heading = google.maps.geometry.spherical.computeHeading({
			lat: 59.802614249571484,
			lng: 17.604689564274832
		}, {
			lat: 59.90613537039398,
			lng: 17.751789236646793
		});

		map = new google.maps.Map(document.getElementById("map"), {
			restriction: {
				latLngBounds: MAP_BOUNDS,
				strictBounds: false,
			},

			minZoom: 2,
			maxZoom: 22,
			zoom: 2,
			center: {
				lat: 52.59905927193015,
				lng: 13.744135878074324
			},
			mapTypeControl: true,
			mapTypeId: 'satellite',
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
				mapTypeIds: ["satellite", "terrain"],
			},
			style: [{
					"elementType": "geometry",
					"stylers": [{
						"color": "#1d2c4d"
					}]
				},
				{
					"elementType": "labels.text",
					"stylers": [{
						"visibility": "off"
					}]
				},
				{
					"elementType": "labels.text.fill",
					"stylers": [{
						"color": "#8ec3b9"
					}]
				},
				{
					"elementType": "labels.text.stroke",
					"stylers": [{
						"color": "#1a3646"
					}]
				},
				{
					"featureType": "administrative.country",
					"elementType": "geometry.stroke",
					"stylers": [{
						"color": "#4b6878"
					}]
				},
				{
					"featureType": "administrative.land_parcel",
					"elementType": "labels.text.fill",
					"stylers": [{
						"color": "#64779e"
					}]
				},
				{
					"featureType": "administrative.province",
					"elementType": "geometry.stroke",
					"stylers": [{
						"color": "#4b6878"
					}]
				},
				{
					"featureType": "landscape.man_made",
					"elementType": "geometry.stroke",
					"stylers": [{
						"color": "#334e87"
					}]
				},
				{
					"featureType": "landscape.natural",
					"elementType": "geometry",
					"stylers": [{
						"color": "#023e58"
					}]
				},
				{
					"featureType": "poi",
					"elementType": "geometry",
					"stylers": [{
						"color": "#283d6a"
					}]
				},
				{
					"featureType": "poi",
					"elementType": "labels.text.fill",
					"stylers": [{
						"color": "#6f9ba5"
					}]
				},
				{
					"featureType": "poi",
					"elementType": "labels.text.stroke",
					"stylers": [{
						"color": "#1d2c4d"
					}]
				},
				{
					"featureType": "poi.park",
					"elementType": "geometry.fill",
					"stylers": [{
						"color": "#023e58"
					}]
				},
				{
					"featureType": "poi.park",
					"elementType": "labels.text.fill",
					"stylers": [{
						"color": "#3C7680"
					}]
				},
				{
					"featureType": "road",
					"elementType": "geometry",
					"stylers": [{
						"color": "#304a7d"
					}]
				},
				{
					"featureType": "road",
					"elementType": "labels.text.fill",
					"stylers": [{
						"color": "#98a5be"
					}]
				},
				{
					"featureType": "road",
					"elementType": "labels.text.stroke",
					"stylers": [{
						"color": "#1d2c4d"
					}]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry",
					"stylers": [{
						"color": "#2c6675"
					}]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry.stroke",
					"stylers": [{
						"color": "#255763"
					}]
				},
				{
					"featureType": "road.highway",
					"elementType": "labels.text.fill",
					"stylers": [{
						"color": "#b0d5ce"
					}]
				},
				{
					"featureType": "road.highway",
					"elementType": "labels.text.stroke",
					"stylers": [{
						"color": "#023e58"
					}]
				},
				{
					"featureType": "transit",
					"elementType": "labels.text.fill",
					"stylers": [{
						"color": "#98a5be"
					}]
				},
				{
					"featureType": "transit",
					"elementType": "labels.text.stroke",
					"stylers": [{
						"color": "#1d2c4d"
					}]
				},
				{
					"featureType": "transit.line",
					"elementType": "geometry.fill",
					"stylers": [{
						"color": "#283d6a"
					}]
				},
				{
					"featureType": "transit.station",
					"elementType": "geometry",
					"stylers": [{
						"color": "#3a4762"
					}]
				},
				{
					"featureType": "water",
					"elementType": "geometry",
					"stylers": [{
						"color": "#0e1626"
					}]
				},
				{
					"featureType": "water",
					"elementType": "labels.text.fill",
					"stylers": [{
						"color": "#4e6d70"
					}]
				}
			]
		});

		<?php
        $res = $db->query("SELECT * FROM master_map WHERE `type` != \"surfops\"");
while ($row = $res->fetch_assoc()) {
    switch ($row["type"]) {
        case "unidentified_signal":
            $icon = "unknown_signal.gif";
            break;
        case "identified_signal":
            $icon = "identified_signal.gif";
            break;
        case "POI":
            $icon = "poi.gif";
            break;
        case "sensor":
            $icon = "sensor.gif";
            break;
        case "surfops":
            $icon = "surfops.gif";
            break;
    }
    ?>
		new google.maps.Marker({
			position: {
				lat: <?=$row["longitude"]?> ,
				lng: <?=$row["latitude"]?>
			},
			map,
			title: "<?=$row["title"]?>",
			icon: "/img/<?=$icon?>",
			draggable: false,
			optimized: false,
		});
		<?php
}
$res = $db->query("SELECT * FROM master_map WHERE `type` = \"surfops\" ORDER BY timestamp ASC");
$x=0;
while ($row = $res->fetch_assoc()) {
    $track[$x]["lat"] = $row["longitude"];
    $track[$x]["lng"] = $row["latitude"];
    $x++;
}
?>

		const surfopsTrack = [
			<?php
                foreach ($track as $id => $coords) {
                    ?>
			{
				lat: <?=$coords["lat"]?> ,
				lng: <?=$coords["lng"]?>
			},
			<?php
                }
?>
		];
		const surfopsPath = new google.maps.Polyline({
			path: surfopsTrack,
			geodesic: true,
			strokeColor: "#58fa39",
			strokeOpacity: 0.5,
			strokeWeight: 2,
		});

		surfopsPath.setMap(map);

		<?php
        $res = $db->query("SELECT * FROM master_map WHERE `type` = \"surfops\" ORDER BY timestamp DESC LIMIT 1");
while ($row = $res->fetch_assoc()) {
    ?>
		new google.maps.Marker({
			position: {
				lat: <?=$row["longitude"]?> ,
				lng: <?=$row["latitude"]?>
			},
			map,
			title: "<?=$row["title"]?>",
			icon: "/img/surfops.gif",
			draggable: false,
			optimized: false,
		});
		<?php
}
?>

		// Create the DIV to hold the control.
		const centerControlDiv = document.createElement("div");
		// Create the control.
		const centerControl = createCenterControl(map);

		// Append the control to the DIV.
		centerControlDiv.appendChild(centerControl);
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(
			centerControlDiv
		);
	}
	window.initMap = initMap;

	// dynamically add markers to map as they become available
	/*
	updateLoop = setInterval(function() {
	    new google.maps.Marker({
	        position: {
	            lat: X,
	            lng: Y
	        },
	        map,
	        title: "KORV",
	        icon: "/img/surfops.gif",
	        draggable: false,
	        optimized: false,
	    });
	    console.log("Checked for new markers to add...");
	}, 4000);
	*/
</script>

</html>