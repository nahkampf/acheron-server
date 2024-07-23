<!DOCTYPE html>
<html>
	<head>
		<title>Leaflet debug page</title>

		<!--  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY" async defer></script> -->
		<script src="https://maps.googleapis.com/maps/api/js?key=" async defer></script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!--  <link rel="stylesheet" href="../Leaflet/dist/leaflet.css" />
		<script type="text/javascript" src="../Leaflet/dist/leaflet-src.js"></script>-->

		<link
			rel="stylesheet"
			href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
			integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
			crossorigin=""
		/>
		<script
			src="https://unpkg.com/leaflet@1.7.1/dist/leaflet-src.js"
			integrity="sha512-I5Hd7FcJ9rZkH7uD01G3AjsuzFy3gqz7HIJvzFZGFt2mrCS4Piw9bYZvCgUE0aiJuiZFYIJIwpbNnDIM6ohTrg=="
			crossorigin=""
		></script>

		<!-- 		<script type="text/javascript" src="dist/Leaflet.GoogleMutant.js"></script> -->
		<script src="https://unpkg.com/leaflet.gridlayer.googlemutant@latest/dist/Leaflet.GoogleMutant.js"></script>
		<style>
			#map {
				/*    margin: 32px; */
				/*    width: auto; */
				/*    overflow: visible; */
				position: absolute;
				left: 15em;
				right: 0;
				height: 100vh;
			}
			body {
				margin: 0;
			}
		</style>
	</head>
	<body>
		<div id="map" class="map"></div>
		<div style="position: absolute; width: 15em; top: 10px; z-index: 500">
			GoogleMutant demo
			<div><button id="dc">DC</button><small>(flyTo)</small></div>
			<div><button id="sf">SF</button><small>(setView, 5 sec)</small></div>
			<div><button id="trd">TRD</button><small>(flyTo 20 sec)</small></div>
			<div><button id="lnd">LND</button><small>(fract. zoom)</small></div>
			<div><button id="kyiv">KIEV</button><small>(setView, fract. zoom)</small></div>
			<div><button id="mad">MAD</button><small>(fitBounds)</small></div>
			<div><button id="nul">NUL</button><small>(image overlay)</small></div>
			<div><button id="stop">stop</button></div>
		</div>

		<script type="text/javascript">
			var mapopts = {
				zoomSnap: 0.25,
			};

			var map = L.map("map", mapopts).setView([0, 0], 1);

			var roadMutant = L.gridLayer
				.googleMutant({
					maxZoom: 24,
					type: "roadmap",
				})
				.addTo(map);

			var satMutant = L.gridLayer.googleMutant({
				maxZoom: 24,
				type: "satellite",
			});

			var terrainMutant = L.gridLayer.googleMutant({
				maxZoom: 24,
				type: "terrain",
			});

			var hybridMutant = L.gridLayer.googleMutant({
				maxZoom: 24,
				type: "hybrid",
			});

			var styleMutant = L.gridLayer.googleMutant({
				styles: [
					{ elementType: "labels", stylers: [{ visibility: "off" }] },
					{ featureType: "water", stylers: [{ color: "#444444" }] },
					{ featureType: "landscape", stylers: [{ color: "#eeeeee" }] },
					{ featureType: "road", stylers: [{ visibility: "off" }] },
					{ featureType: "poi", stylers: [{ visibility: "off" }] },
					{ featureType: "transit", stylers: [{ visibility: "off" }] },
					{ featureType: "administrative", stylers: [{ visibility: "off" }] },
					{
						featureType: "administrative.locality",
						stylers: [{ visibility: "off" }],
					},
				],
				maxZoom: 24,
				type: "roadmap",
			});

			var trafficMutant = L.gridLayer.googleMutant({
				maxZoom: 24,
				type: "roadmap",
			});
			trafficMutant.addGoogleLayer("TrafficLayer");

			var transitMutant = L.gridLayer.googleMutant({
				maxZoom: 24,
				type: "roadmap",
			});
			transitMutant.addGoogleLayer("TransitLayer");

			var kyiv = [50.5, 30.5],
				lnd = [51.51, -0.12],
				sf = [37.77, -122.42],
				dc = [38.91, -77.04],
				trd = [63.41, 10.41],
				madBounds = [
					[40.7, -4.19],
					[40.12, -3.31],
				],
				mad = [40.4, -3.7];

			var marker1 = L.marker(kyiv).addTo(map),
				marker2 = L.marker(lnd).addTo(map),
				marker3 = L.marker(dc).addTo(map),
				marker4 = L.marker(sf).addTo(map),
				marker5 = L.marker(trd).addTo(map),
				marker6 = L.marker(mad).addTo(map);

			var rectangle = L.rectangle(madBounds).addTo(map);

			document.getElementById("dc").onclick = function () {
				map.flyTo(dc, 4);
			};
			document.getElementById("sf").onclick = function () {
				map.setView(sf, 10, { duration: 5, animate: true });
			};
			document.getElementById("trd").onclick = function () {
				map.flyTo(trd, 10, { duration: 20 });
			};
			document.getElementById("lnd").onclick = function () {
				map.flyTo(lnd, 9.25);
			};
			document.getElementById("kyiv").onclick = function () {
				map.setView(kyiv, 9.25);
			};
			document.getElementById("nul").onclick = function () {
				map.flyTo([0, 0], 10);
			};
			document.getElementById("mad").onclick = function () {
				map.fitBounds(madBounds);
			};
			document.getElementById("stop").onclick = function () {
				map.stop();
			};

			var grid = L.gridLayer({
				attribution: "Debug tilecoord grid",
			});

			grid.createTile = function (coords) {
				var tile = L.DomUtil.create("div", "tile-coords");
				tile.style.border = "1px solid black";
				tile.style.lineHeight = "256px";
				tile.style.textAlign = "center";
				tile.style.fontSize = "20px";
				tile.innerHTML = [coords.x, coords.y, coords.z].join(", ");

				return tile;
			};

			L.control
				.layers(
					{
						Roadmap: roadMutant,
						Aerial: satMutant,
						Terrain: terrainMutant,
						Hybrid: hybridMutant,
						Styles: styleMutant,
						Traffic: trafficMutant,
						Transit: transitMutant,
					},
					{
						"Tilecoord grid": grid,
					},
					{
						collapsed: false,
					}
				)
				.addTo(map);
		</script>
	</body>
</html>
