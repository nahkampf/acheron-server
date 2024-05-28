<?php
if ($_POST) {
    foreach ($_POST["surfers"] as $surfer) {
        Acheron\Biostate::setStatus($surfer, $_POST["multistatus"]);
    }
}
?>
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
                        <th></th>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                <form method="post" action="">
<?php
$surfers = Acheron\Surfops::getAll();
foreach ($surfers as $id => $surfer) {
    $biomonitor = Acheron\Biomonitor::getBiomonitorForSurferID($surfer->id);
?>
                    <tr>
                        <td><input type="checkbox" name="surfers[]" value="<?=$surfer->id?>"></td>
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
            <br>
            Set status for selected people: <br>
            <select name="multistatus">
            <?php
            $modes = Acheron\Biostate::getAll();
            foreach ($modes as $key => $val) {
            ?>
                <option value="<?=$val->id?>"><?=$val->name?></option>
            <?php
            }
            ?>
            </select>
            <input class="pure-button pure-button-primary" type="submit" value=" SET MULTIPLE STATUS ">
            </form>
        </div>
    </div>
</div>