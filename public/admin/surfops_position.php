<?php
if ($_POST) {
    $db = new Acheron\DB();
    $coords = explode(",", $_POST["latlang"]);
    $lat = trim($coords[0]); $lng = trim($coords[1]);
    $sql = "INSERT INTO surfops_ SET `timestamp` = NOW(), latitude={$lat}, longitude={$lng}";
    $db->query($sql . $add);
    echo "OK!<br>";
}
?>
<div class="header">
    <h1>SURFOPS POSITION</h1>
</div>

<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
        <form method="post" enctype="multipart/form-data">
            <table class="pure-table">
                <tr>
                    <td>
                        <label>Coordinates (lat, lng)</label>
                    </td>
                    <td>
                        <input type="text" name="latlang" placeholder="57.12,17.32"> <a href="map.php" target="_blank" class="pure-button pure-button-primary">Get from map</a>
                    </td>
                </tr>
            </table>
            <input type="submit" value=" SAVE " class="pure-button pure-button-primary">
        </form>
        </div>
    </div>
</div>
