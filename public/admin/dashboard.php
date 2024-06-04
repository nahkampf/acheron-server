<div class="header">
    <h1>DASHBOARD</h1>
</div>

<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-2">
        <table class="pure-table pure-table-striped">
            <thead>
                <tr>
                    <th>CLIENT</th>
                    <th>IP</th>
                    <th>AGE</th>
                </tr>
            </thead>
            <tbody>
<?php
$expected_clients = [
    "ARCHIVE",
    "GEOLOC",
    "SCIENCE",
    "SENSOR",
    "SIGINT",
    "SURCOM",
];
$agg_clients = Acheron\Client::getAll(true);
$db = new Acheron\DB();
foreach ($expected_clients as $eclient) {
    $ip = "---";
    $diff = "NO CLIENT!";
    foreach ($agg_clients as $idx => $client) {
        if ($eclient != $client["id"]) continue;
        if ($client["ip"]) {
            $ip = $client["ip"];
        }
        if ($client["last_report"]) {
            $date1 = strtotime($client["last_report"]);
            $date2 = strtotime($db->getNow());
            $diff = abs($date2 - $date1);
        }
    }
?>
                <tr>
                    <td>
                        <?=$eclient?>
                    </td>
                    <td>
                        <?=$ip?>
                    </td>
                    <td>
                        <span class="<?=($diff > 60 || $diff == "NO CLIENT!") ? "red" : "green"?>"><?=$diff?><?=($diff != "NO CLIENT!") ? "s ago" :""?></span>
                    </td>
                </tr>
<?php
}
?>
            </tbody>
        </table>        
        </div>
        <div class="pure-u-1-2">
            hehe
        </div>
    </div>
</div>