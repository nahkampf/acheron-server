<?php
require "../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();
?><!DOCTYPE html>
<html>
    <head>
        <title>Acheron Map</title>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?=$_ENV["GOOGLE_KEY"]?>" async defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

        <script src="https://unpkg.com/leaflet.gridlayer.googlemutant@latest/dist/Leaflet.GoogleMutant.js"></script>
        <style>
            #map {
                /*    margin: 32px; */
                /*    width: auto; */
                /*    overflow: visible; */
                height: 100vh;
            }
            body {
                margin: 0;
            }
        </style>
        <script src="leaflet.measure.js"></script>
        <link rel="stylesheet" href="leaflet.measure.css">
    </head>
    <body>
        <div id="map" class="map"></div>
        <script type="text/javascript">
            var mapopts = {
            };

            // markers
            var yellowIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            var greenIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            var redIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            var violetIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var acheron = [52.85168195917985, 13.682466520411188];
            var mapBounds = [
                [52.883494069515926, 13.649227444477214],
                [52.827334360027045, 13.833713838794116]
            ]

            var map = L.map("map", mapopts).setView(acheron, 16);
            // fetch the sensors
<?php
require "../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();
$db = new Acheron\DB();
$sensors = Acheron\Sensor::getAll();
foreach($sensors as $idx => $sensor) {
?>
            var sensor_<?=$sensor->name?> = L.marker([<?=$sensor->lat?>, <?=$sensor->lng?>], {icon: violetIcon}).addTo(map).bindPopup("<b><?=$sensor->name?></b>").openPopup();;
<?php
}
?>

            // find all signals on map
<?php
$signals = Acheron\Signal::getAll();
foreach($signals as $idx => $signal) {
    $emitter = Acheron\EmitterType::getById($signal->emitter);
?>
            var sig_<?=$signal->id?> = L.marker([<?=$signal->lat?>, <?=$signal->lng?>], {icon: redIcon}).addTo(map).bindPopup("<b><?=$emitter[0]["number"] . " " . $emitter[0]["name"]?></b><br><?=substr($signal->timestamp, 11)?>").openPopup();;
<?php
}
?>
            // and now the surfops team
<?php
$surfops = $db->get("SELECT * FROM surfops_positions ORDER BY `timestamp` DESC LIMIT 1")[0];
?>
            var surfops = L.marker([<?=$surfops["latitude"]?>, <?=$surfops["longitude"]?>], {icon: greenIcon}).addTo(map).bindPopup("<b>KERES</b>").openPopup();
<?php
?>

            var satMutant = L.gridLayer.googleMutant({
                maxZoom: 24,
                type: "satellite",
            }).addTo(map);


            var acheronMarker = L.marker(acheron, {icon: yellowIcon}).addTo(map);

            L.control.scale().addTo(map);
            L.control.measure().addTo(map);
            var measureAction = new L.MeasureAction(map, {
                model: "distance", // 'area' or 'distance', default is 'distance'
            });
            //measureAction.enable();
            map.setView(acheron, 16);
            map.doubleClickZoom.disable();

            map.on('dblclick', function(e){
                var coord = e.latlng;
                var lat = coord.lat;
                var lng = coord.lng;
//                alert("Lat: " + lat + ", lng: " + lng + " - copied to clipboard");
                const dialog = document.querySelector("dialog");
                dialog.innerHTML = "<b>" + lat + "," + lng +"</b>";
                dialog.showModal();
//                console.log("You clicked the map at latitude: " + lat + " and longitude: " + lng);
                });
        </script>
<dialog id="coords">
</dialog>
    </body>
</html>
