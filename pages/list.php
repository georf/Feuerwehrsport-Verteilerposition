<?php

if (!defined('TEAM')) {
	exit();
}


$rows = $db->getRows("
	SELECT *
	FROM (
		SELECT *
		FROM `verteiler` v
		WHERE `team` = '".TEAM."'
		ORDER BY `set` DESC
	) n
	GROUP BY n.`name`
	ORDER BY n.`name`;");

echo '<h4>Liste zum Drucken: <a href="?page=report&amp;team='.TEAM.'">PDF</a></h4>';

echo '<table id="list">';
echo '<tr class="head"><td></td><td></td><td></td><th>Bahnmitte</th></tr>';
foreach ($rows as $row) {
	echo '<tr>
		<td class="name"><span class="realname">',htmlspecialchars($row['name']),'</span> <a href="?page=edit&amp;id='.$row['id'].'"><img src="b_edit.png" alt="" title="Bearbeiten"/></a><br/><span class="date">'.date('d.m.Y H:i', strtotime($row['set'])).'</span><br/><span class="comment">'.htmlspecialchars($row['comment']).'</span></td>
		<td class="degree">',$row['degree'],'</td>
		<td class="cm">',$row['cm'],'</td>
		<td class="verteiler"></td>
	</tr>';
}
echo '</table>';


$rows = $db->getRows("
	SELECT *
	FROM `verteiler` v
	WHERE `team` = '".TEAM."'
	ORDER BY `set` DESC
	LIMIT 1;");
echo '<h4>Letzte Änderung: '.date('d.m.Y H:i', strtotime($rows[0]['set'])).'</h4>';
