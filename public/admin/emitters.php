<?php
if ($_POST) {
    // handle uploads
    echo "<pre>";
    if (!empty($_FILES["spectrogram"]["name"])) {
        if (move_uploaded_file($_FILES['spectrogram']['tmp_name'], "../assets/spectrograms/" . basename($_FILES['spectrogram']['name']))) {
            $spectrogram = basename($_FILES['spectrogram']['name']);
        } else {
            die("Error in moving " . $_FILES["spectrogram"]["name"]);
        }
    }
    if (!empty($_FILES["waveform"]["name"])) {
        if (move_uploaded_file($_FILES['waveform']['tmp_name'], "../assets/waveforms/" . basename($_FILES['waveform']['name']))) {
            $waveform = basename($_FILES['waveform']['name']);
        } else {
            die("Error in moving " . $_FILES["waveform"]["name"]);
        }
    }
    $db = new Acheron\DB();
    $maxvel = ((int)$_POST["maxvelocity"] == 0) ? "NULL" : (int)$_POST["maxvelocity"];
    $cw1freq = ((int)$_POST["cw1freq"] == 0) ? "NULL" : $_POST["cw1freq"];
    $cw2freq = ((int)$_POST["cw2freq"] == 0) ? "NULL" : $_POST["cw2freq"];
    $cw3freq = ((int)$_POST["cw3freq"] == 0) ? "NULL" : $_POST["cw3freq"];
    $dc_start = $dc_midlle = $dc_end = "N";
    foreach ($_POST["datacluster"] as $key => $val) {
        if ($key == "start") $dc_start = "Y";
        if ($key == "middle") $dc_middle = "Y";
        if ($key == "end") $dc_end = "Y";
    }
    $sql = sprintf(
        "INSERT INTO emitter_types SET 
        number=\"%s\",
        name=\"%s\",
        type=\"%s\",
        visible_to_players=\"%s\",
        carrierwave1_frequency=%s,
        carrierwave2_frequency=%s,
        carrierwave3_frequency=%s,
        datacluster_start=\"%s\",
        datacluster_middle=\"%s\",
        datacluster_end=\"%s\",
        spectrogram_sample=\"%s\",
        waveform_file=\"%s\",
        fingerprint_description=\"%s\",
        known_max_velocity=%s,
        orgnotes=\"%s\"
    ",
        $db->e($_POST["number"]),
        $db->e($_POST["name"]),
        $db->e($_POST["type"]),
        $db->e($_POST["known"]),
        $cw1freq,
        $cw2freq,
        $cw3freq,
        $db->e($dc_start),
        $db->e($dc_middle),
        $db->e($dc_end),
        $db->e($spectrogram),
        $db->e($waveform),
        $db->e($_POST["description"]),
        $db->e($maxvel),
        $db->e($_POST["orgnotes"])
    );
    $db->query($sql);
    header("Location: ?page=emitters");
    die();
}

?>
<div class="header">
    <h1>EMITTERS</h1>
</div>

<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
<?php
if (@$_GET["action"] == "new") {
?>
<h2>Create new emitter</h2>
<form method="post" enctype="multipart/form-data">
    <table class="pure-table">
    <tr>
            <td>
            <label for="number">XM number</label>
            </td>
            <td>
            <input name="number" type="text" placeholder="XM01"> (Next available: XM28)
            </td>
        </tr>
        <tr>
            <td>
            <label for="number">Name</label>
            </td>
            <td>
            <input name="name" type="text" placeholder="PUPPETMASTER">
            </td>
        </tr>
        <tr>
            <td>
            <label for="type">Type</label>
            </td>
            <td>
            <select name="type">
                <option value="aerial">Aerial</option>
                <option value="ground">Mobile ground</option>
                <option value="static">Static ground</option>
                <option value="unknown">Unknown</option>
                <option value="orbital">Orbital</option>
            </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h2>Fingerprinting</h2>
            </td>
        </tr>
        <tr>
            <td>
            <label for="spectrogram">Spectrogram image (1024x768)</label>
            </td>
            <td>
                <input type="file" name="spectrogram">
            </td>
        </tr>
        <tr>
            <td>
            <label for="waveform">Sound file (.wav)</label>
            </td>
            <td>
                <input type="file" name="waveform">
            </td>
        </tr>
        <tr>
            <td>
            <label for="cw1freq">Carrier wave 1 freq</label>
            </td>
            <td>
                <input type="text" name="cw1freq" placeholder="0"> (Leave empty for none)
            </td>
        </tr>
        <tr>
            <td>
            <label for="cw2freq">Carrier wave 2 freq</label>
            </td>
            <td>
                <input type="text" name="cw2freq" placeholder="0"> (Leave empty for none)
            </td>
        </tr>
        <tr>
            <td>
            <label for="cw3freq">Carrier wave 3 freq</label>
            </td>
            <td>
                <input type="text" name="cw3freq" placeholder="0"> (Leave empty for none)
            </td>
        </tr>
        <tr>
            <td>
            <label for="datacluster">Data cluster</label>
            </td>
            <td>
                <input type="checkbox" name="datacluster[start]" value="Y"> Start<br>
                <input type="checkbox" name="datacluster[middle]" value="Y"> Middle<br>
                <input type="checkbox" name="datacluster[end]" value="Y"> End<br>
                (Where does the data cluster for the signal message show up on the spectrogram)
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h2>For the archive</h2>
            </td>
        </tr>
        <tr>
            <td>
            <label for="known">Known (is in fingerprint library)</label>
            </td>
            <td>
                <input type="radio" name="known" value="Y" checked> Known at start
                <input type="radio" name="known" value="N"> Unknown at start
            </td>
        </tr>
        <tr>
            <td>
                <label for="description">Description</label>
            </td>
            <td>
                <textarea style="width:100%;" name="description" placeholder="Write (in character) what is known about this machine type in the science archives"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label for="maxvelocity">Known max velocity</label>
            </td>
            <td>
                <input type="text" name="maxvelocity" placeholder="5"> m/s
            </td>
        </tr>
        <tr>
            <td>
                <label for="orgnotes">Organizer notes (not visible to players)</label>
            </td>
            <td>
                <textarea style="width:100%;" name="orgnotes" placeholder="Stuff GMs or orgs might need to know"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value=" SAVE ">
            </td>
        </tr>
    </table>
    <br>
</form>
<?php
die();
}
?>

            <a href="?page=emitters&action=new" class="pure-button pure-button-primary">ADD NEW</a>
            <br>
            <h2>ALL EMITTER TYPES</h2>
            <table class="pure-table pure-table-striped">
                <thead>
                    <tr>
                        <th>XM number</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                        <td>XM1</td>
                        <td>Hvy Orbital Weapons Platform</td>
                        <td>Aerial</td>
                        <td>
                            <button class="pure-button pure-button-primary">EDIT</button>
                            <button class="pure-button button-warning">DELETE</button>
                        </td>
                    </tr>
                    <tr>
                        <td>XM2</td>
                        <td>Light Orbital Weapons Platform</td>
                        <td>Aerial</td>
                        <td>
                            <button class="pure-button pure-button-primary">EDIT</button>
                            <button class="pure-button button-warning">DELETE</button>
                        </td>
                    </tr>
                    <tr>
                        <td>XM3</td>
                        <td>Hvy Orbital Tug</td>
                        <td>Aerial</td>
                        <td>
                            <button class="pure-button pure-button-primary">EDIT</button>
                            <button class="pure-button button-warning">DELETE</button>
                        </td>
                    </tr>
                    <tr>
                        <td>XM4</td>
                        <td>Light Orbital Tug</td>
                        <td>Aerial</td>
                        <td>
                            <button class="pure-button pure-button-primary">EDIT</button>
                            <button class="pure-button button-warning">DELETE</button>
                        </td>
                    </tr>
                    <tr>
                        <td>XM5</td>
                        <td>Hvy Orbital Dropship</td>
                        <td>Aerial</td>
                        <td>
                            <button class="pure-button pure-button-primary">EDIT</button>
                            <button class="pure-button button-warning">DELETE</button>
                        </td>
                    </tr>
                    <tr>
                        <td>XM6</td>
                        <td>Light Orbital Dropship</td>
                        <td>Aerial</td>
                        <td>
                            <button class="pure-button pure-button-primary">EDIT</button>
                            <button class="pure-button button-warning">DELETE</button>
                        </td>
                    </tr>
                    <tr>
                        <td>XM7</td>
                        <td>High Altitude Comm Relay</td>
                        <td>Aerial</td>
                        <td>
                            <button class="pure-button pure-button-primary">EDIT</button>
                            <button class="pure-button button-warning">DELETE</button>
                        </td>
                    </tr>
                    <tr>
                        <td>XM8</td>
                        <td>Low Altitude Comm Relay</td>
                        <td>Aerial</td>
                        <td>
                            <button class="pure-button pure-button-primary">EDIT</button>
                            <button class="pure-button button-warning">DELETE</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>