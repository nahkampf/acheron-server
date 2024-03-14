<div class="header">
    <h1>CLIENTS</h1>
</div>

<div class="content">
    <div class="pure-g">
        <div class="pure-u-1-1">
            <h2>REGISTERED CLIENTS</h2>
            <table class="pure-table pure-table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>IP</th>
                        <th>Last reported in</th>
                        <th>Assigned payload</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $clients = Acheron\Client::getAll();
                    foreach ($clients as $key => $client) {
                        ?>
                    <tr>
                        <td><?=$client["id"]?>
                        </td>
                        <td><?=$client["ip"];?>
                        </td>
                        <td><?=$client["last_report"];?>
                            (<span class="time_since_update"
                                data-datetime="<?=$client["last_report"]?>"></span>)
                        </td>
                        <td>
                            <form class="pure-form">
                                <select name="payload">
                                    <option value="">--</option>
                                    <option value="SENSOR">SENSOR</option>
                                    <option value="SIGINT">SIGINT</option>
                                    <option value="SURCOM">SURCOM</option>
                                    <option value="SCIENCE">SCIENCE</option>
                                    <option value="ARCHIVE">ARCHIVE</option>
                                    <option value="CMDR">COMMANDER</option>
                                    <option value="GENERIC">GENERIC</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <button class="pure-button button-warning">REBOOT</button>
                            <button class="pure-button pure-button-primary">SSH</button>
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