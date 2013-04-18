<?php

if (isPost('name', 'cm', 'degree', 'team')) {
	$ret = $db->insertRow('verteiler', array(
		'name' => $_POST['name'],
		'team' => $_POST['team'],
		'degree' => $_POST['degree'],
		'cm' => $_POST['cm'],
	));

	if ($ret !== false) {
		header('Location: ?succes=ok&page='.$_POST['team']);
		ob_clean();
		exit();
	}
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $row = $db->getFirstRow("
    SELECT *
    FROM `verteiler`
    WHERE `id` = '".$db->escape($_GET['id'])."'
    LIMIT 1;");
  if ($row) {
    echo
      '<div style="display:none;">',
        '<span id="oldDegree">',$row['degree'],'</span>',
        '<span id="oldCm">',$row['cm'],'</span>',
        '<span id="oldName">',$row['name'],'</span>',
        '<span id="oldTeam">',$row['team'],'</span>',
      '</div>';
  }
}

?>

<h3 style="margin-bottom: 40px;">Einfach Verteiler rotieren, positionieren und Namen eintragen.</h3>

<div class="row">
	<div class="span6">
		<table><tr>
			<td style="border-right:2px solid #E6E6FA;height: 240px;text-align:center;width:70px;">
			<p><a class="btn" href="#" id="rotate-min">⟲</a></p>
			<p><a class="btn" href="#" id="push-min">⇐</a></p>
			</td>
			<td style="background:url(hintergrund.png) top center no-repeat; margin:50px;text-align:center;width:280px;">
			<img src="verteiler.png" id="verteiler" alt="verteiler" style="width:150px;"/>
			</td>
			<td style="border-left:2px solid #E6E6FA; height: 200px;text-align:center;width:70px;">
			<p><a class="btn" href="#" id="rotate-max">⟳</a></p>
			<p><a class="btn" href="#" id="push-max">⇒</a></p>
			</td>
		</tr></table>
	</div>
	<div class="span4">
		<form method="post" action="">
		<table>
		<tr><th>Winkel:</th><td><span id="degree">0</span> Grad</td></tr>
		<tr><th>Ausrichtung:</th><td><span id="cm">0</span> cm</td></tr>
		<tr><th>Mannschaft:</th><td><select name="team">
			<option value="men">Männer</option>
			<option value="women">Frauen</option>
		</select></td></tr>
		<tr><th>Name:</th><td><input type="text" name="name"/></td></tr>
		</table>
		<input type="hidden" id="degree-h" value="0" name="degree"/>
		<input type="hidden" id="cm-h" value="0" name="cm"/>
		<button type="submit">Speichern</button>
		</form>
	</div>
</div>
