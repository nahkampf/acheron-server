<?php
use Acheron\Phrase;

if(@$_POST) {
    $db = new Acheron\DB();
    $phraseIds = null;
    $cleartext = null;
    // handle tokens in message
    $tokens = explode("@@", $_POST["message"]);
    foreach($tokens as $idx => $token) {
        // extract phrase and ID
        $phrase = explode(":", $token);
        if (count($phrase) < 2) {
            continue;
        }
        $seq = $db->get("SELECT `sequence` FROM message_corpus WHERE id=" . $phrase[1])[0]["sequence"];
        $phraseIds[] = $phrase[1];
        $cleartext .= trim($phrase[0]) . " / ";
        $msg[] = ["phraseId" => $phrase[1], "cleartext" => trim($phrase[0]), "sequence" => $seq];
    }
    // construct encrypted message
    function randomString($number_of_chars=1) {
        $chars = Acheron\CP437::generateAsciiTable();
        $crypt = "";
        for ($x = 0; $x < $number_of_chars +1; $x++) {
            $crypt .= $chars[array_rand($chars, 1)]["cp437code"] ." ";
        }
        return $crypt;
    }
    // fist, add intro character
    $start_pad = mt_rand(1, 15);
    $crypt = randomString($start_pad);
    foreach($msg as $idx => $phrase) {
        $crypt .= $phrase["sequence"] ." " ;
        // add x amount of noise
        $crypt .= randomString(mt_rand(10,30));
    }
    $sql = "INSERT INTO messages SET cleartext_message=\"" . $db->e($cleartext). "\", cp437_message=\"" . $db->e($crypt) . "\", phraseIds=\"" . implode(";", $phraseIds). "\"";
    echo $sql;
    $db->query($sql);
}
?>
<div class="header">
    <h1>MESSAGES</h1>
</div>
<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
        <?php
if (@$_GET["action"] == "newmessage") {
?>
<h2>Create message</h2>
<form method="POST">
    <textarea id="message" name="message" style="width:100%" autofocus></textarea>
    <br>
    <input type="submit" value=" SAVE ">
    <br>
    <h3>Phrases:</h3>
<?php
$phrases = Acheron\Phrase::getAll();
foreach ($phrases as $idx => $phrase) {
?>
<a href="#" class="phrase-button pure-button" data-id="<?=$phrase->id?>" data-phrase="<?=$phrase->phrase?>"><?=$phrase->phrase?> (<?=$phrase->sequence?>)</a> 
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
            console.log(event.target.dataset.id);
            document.getElementById('message').textContent
                = document.getElementById('message').textContent
                + " "
                + event.target.dataset.phrase + ":" + event.target.dataset.id + "@@";
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