<?php
$db = new Acheron\DB();
if ($_GET["action"] == "delete") {
    $sql = "DELETE FROM samples WHERE id=" . (int)$_GET["id"];
    $db->query($sql);
}
if ($_POST) {
    $sql = "INSERT INTO samples SET data=\"" . $db->e($_POST["data"]) . "\"";
    $res = $db->query($sql);
}
?>
<div class="header">
    <h1>SAMPLES</h1>
</div>

<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
            <h2>Create new sample</h2>
            <form method="post" enctype="multipart/form-data">
                <table class="pure-table">
                    <tr>
                        <td>
                            <label for="data">Sample data</label>
                        </td>
                        <td>
                            <textarea name="data" id="data" autofocus style="width:600px;height:500px;">
SAMPLE REFERENCE: KERES SURFOPS TEAM
SAMPLE AREA: ACHERON AREA OF OPERATIONS
SAMPLE TYPE: AIR
SAMPLE METHOD: FIELD SAMPLER MKIII (ATLAS 1.1.12)
──────────
Prometheus preliminary auto-analyzer results:

                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value=" SAVE " class="pure-button pure-button-primary">
                        </td>
                    </tr>
                </table>
            </form>
            <hr>
            <h2>Samples</h2>
            <table class="pure-table">
                <thead>
                    <th>Time</th>
                    <th>Data</th>
                    <th>Analyzed?</th>
                    <th></th>
                </thead>

<?php
$samples = $db->get("SELECT * FROM samples ORDER BY `timestamp` DESC");
foreach (@$samples as $idx => $sample) {
?>
                <tr>
                    <td style="vertical-align: top;"><?=$sample["timestamp"]?></td>
                    <td style="vertical-align: top;"><?=$sample["data"]?></td>
                    <td style="vertical-align: top;"><?=$sample["analyzed"]?></td>
                    <td style="vertical-align: top;"><a href="?page=samples&action=delete&id=<?=$sample["id"]?>" class="pure-button button-error">DELETE</a></td>
                </tr>
<?php
}
?>
            </table>
        </div>
    </div>
</div>

