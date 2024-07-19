<?php

if (isset($_GET["state"])) {
    Acheron\Alert::set($_GET["state"]);
}
?>
<div class="header">
    <h1>ALERTS</h1>
</div>
<script type="text/javascript">
function setAlert(state) {
    if(window.confirm('Are you SURE you want to set Code ' + state.toUpperCase() + "?") == true) {
        window.location="?page=alerts&state=" + state;
    }
}
</script>
<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
            CURRENT CONDITION:<br>
            <h1><?=strtoupper(Acheron\Alert::get()["current_state"]);?></h1>
            <a onClick="setAlert('red')" class="pure-button button-error">CODE RED</a>
            <a onClick="setAlert('blue')" class="pure-button pure-button-primary">CODE BLUE</a>
            <a onClick="setAlert('green')" class="pure-button button-success">CODE GREEN</a>
        </div>
    </div>
</div>
