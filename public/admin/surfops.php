<div class="header">
    <h1>SURFOPS</h1>
</div>
<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
            <h2>SURFOPS team</h2>
            <table class="pure-table pure-table-striped">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
<?php
$surfers = Acheron\Surfops::getAll();
foreach ($surfers as $id => $surfer) {
    $biomonitor = Acheron\Biomonitor::getBiomonitorForSurferID($surfer->id);
?>
                    <tr>
                        <td><?=$surfer->rank?></td>
                        <td><?=$surfer->name?></td>
                        <td>
                            <select name="state[<?=$surfer->id?>]">
                            <?php
                            $modes = Acheron\Biostate::getAll();
                            foreach ($modes as $key => $val) {
                            ?>
                                <option <?=($biomonitor["currentState"] == $val->id) ? "selected" : ""?> value="<?=$val->id?>"><?=$val->name?></option>
                            <?php
                            }
                            ?>
                            </select>
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