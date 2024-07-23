<div id="menu">
	<div class="pure-menu">
		<a class="pure-menu-heading" href="?">ADMIN</a>

		<ul class="pure-menu-list">
			<li class="pure-menu-item"><a href="?page=clients" class="pure-menu-link">Map settings</a></li>
			<li class="pure-menu-item"><a href="?page=map" class="pure-menu-link">Map control</a></li>
			<li class="pure-menu-item"><a href="?page=clients" class="pure-menu-link">Clients</a></li>
			<li class="pure-menu-item"><a href="?page=emitters" class="pure-menu-link">Emitters</a></li>
			<li class="pure-menu-item"><a href="?page=signals" class="pure-menu-link">Signals</a></li>
			<li class="pure-menu-item"><a href="?page=sensors" class="pure-menu-link">Sensors</a></li>
			<li class="pure-menu-item"><a href="?page=archive" class="pure-menu-link">Archive/DB</a></li>
			<li class="pure-menu-item"><a href="?page=messages" class="pure-menu-link">Messages</a></li>
			<li class="pure-menu-item"><a href="?page=players" class="pure-menu-link">Players</a></li>
			<li class="pure-menu-item"><a href="?page=alerts" class="pure-menu-link">Alerts</a></li>
			<li class="pure-menu-item"><a href="?page=surfops" class="pure-menu-link">SURFOPS</a></li>
			<li class="pure-menu-item"><a href="?page=tools" class="pure-menu-link">Admin tools</a></li>
		</ul>
		<br>
		<hr>
		<br>
		<table>
			<tr>
				<td>IP</td>
				<td><?=$_SERVER['SERVER_ADDR'];?>
				</td>
			</tr>
			<tr>
				<td>Diegetic time</td>
				<td><?=date("Y-m-d H:i:s")?>
				</td>
			</tr>
			<tr>
				<td>Live clients</td>
				<td>1
				</td>
			</tr>
			<tr>
				<td>Stale clients</td>
				<td>3
				</td>
			</tr>
		</table>
	</div>
</div>