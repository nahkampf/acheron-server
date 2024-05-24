<?php
use Acheron\Phrase;
?>
<div class="header">
    <h1>MESSAGES</h1>
</div>
<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
        <?php
if ($_GET["action"] == "newmessage") {
?>
<h2>Create message</h2>
<form method="POST">
    <textarea id="message" name="message" style="width:100%" autofocus></textarea>
    <br>
    <h3>Phrases:</h3>
<?php
$phrases = Acheron\Phrase::getAll();
foreach ($phrases as $idx => $phrase) {
?>
<a href="#" class="phrase-button pure-button" data-phrase="<?=$phrase->phrase?>"><?=$phrase->phrase?> (<?=$phrase->sequence?>)</a> 
<?php
}
?>
</form>
<script>
window.addEventListener('load', function(event) {
    //document.getElementById('message').focus();
    const phraseButtons = document.querySelectorAll(".phrase-button");
    phraseButtons.forEach((phraseButton) => {
        phraseButton.onclick = function(event) {
            document.getElementById('message').textContent
                = document.getElementById('message').textContent
                + " "
                + "@" + event.target.dataset.phrase + "@";
        }
    });
}); 
</script>
<?php
die();
}
?>

        <a href="?page=messages&action=newmessage" class="pure-button pure-button-primary">NEW MESSAGE</a>
        <a href="?page=messages&action=newphrase" class="pure-button button-secondary">NEW PHRASE</a>
            <br>

        <h2>Corpus</h2>
            <table class="pure-table pure-table-striped">
                <thead>
                    <tr>
                        <th>Phrase</th>
                        <th>Sequences</th>
                        <th>Known?</th>
                    </tr>
                </thead>
                <tbody>
<?php
$phrases = Acheron\Phrase::getAll();
foreach ($phrases as $idx => $phrase) {
?>
                <tr>
                        <td>
                        <?=$phrase->phrase?>
                        </td>
                        <td>
                        <code><?=$phrase->sequence?></code>
                        </td>
                        <td>
                        <i class="<?=($phrase->known == 1) ? "green" : ""?> fa-solid fa-square-<?=($phrase->known == 1) ? "check" : "question"?>"></i>
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