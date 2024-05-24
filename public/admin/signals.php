<?php
use Acheron\EmitterType;
?>
<div class="header">
    <h1>SIGNALS</h1>
</div>

<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
        <?php
if (isset($_GET["action"]) && $_GET["action"]=="new") {
?>
        <h2>Create new signal</h2>
        <form method="post" enctype="multipart/form-data">
            <table class="pure-table">
                <tr>
                    <td>
                        <label for="emitter">Emitter</label>
                    </td>
                    <td>
                        <select name="emitter">
<?php
$emitters = Acheron\EmitterType::getAll();
foreach($emitters as $idx => $emitter) {
?>
                            <option value="<?=$emitter["id"]?>"><?=$emitter["name"]?> (<?=$emitter["number"]?>) [<?=$emitter["type"]?>]</option>
<?php
}
?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Coordinates (lat, lng)</label>
                    </td>
                    <td>
                        <input type="text" name="latlang" placeholder="57.12,17.32"> <a href="#" target="_blank" class="pure-button pure-button-primary">Get from map</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="velocity">Velocity (m/s)</label>
                    </td>
                    <td>
                        <input type="text" name="velocity" placeholder="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="heading">Heading</label>
                    </td>
                    <td>
                        <input type="text" name="heading" placeholder="221">&deg;
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="message">Message</label>
                    </td>
                    <td>
                        <select name="message">
                            <option>0 - NO MSG/UNDECIPHERABLE</option>
                            <option>1 - ALL SYSTEMS NOMINAL</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="timestamp">Timestamp</label>
                    </td>
                    <td>
                        <input type="text" name="timestamp" placeholder="<?=date("Y-m-d H:i:s");?>"> Leave empty for "now", but can be set to a future date
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>
</div>
<?php
die();
}
?>
        <a href="?page=signals&action=new" class="pure-button pure-button-primary">ADD NEW</a>
            <br>

        <table class="pure-table">
        <thead>
            <tr>
                <th>Time</th>
                <th>Emitter</th>
                <th>Pos</th>
                <th>P Sensor</th>
                <th>S Sensor</th>
                <th>Heading & Vel</th>
                <th>Message</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
<?php
foreach (Acheron\Signal::getAll() as $signal) {
?>
          <tr>
                <td><?=$signal->timestamp?></td>
                <td><?=$signal->emitter?></td>
                <td><?=$signal->lat?>,<?=$signal->lng?></td>
                <td><?=$signal->primary_sensor["name"]?></td>
                <td><?=$signal->secondary_sensor["name"]?></td>
                <td><?=$signal->heading?> (<?=$signal->velocity?>m/s)</td>
                <td><?=$signal->interceptTime?></td>
                <td>
                    <i class="<?=(!empty($signal->interceptTime)) ? "green" : ""?> fa-solid fa-tower-cell" title="intercepted at <?=$signal->interceptTime?>"></i>
                    <i class="<?=(!empty($signal->designation)) ? "green" : ""?> fa-solid fa-input-text" title="designated <?=$signal->designation?>"></i>
                    <i class="fa-solid fa-binary-circle-check" title="decrypted message"></i>
                </td>
            </tr>
<?php
}
?>
        </tbody>
        </table>
        </div>
    </div>
</div>