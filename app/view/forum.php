		<h2>Foren</h2>
		<p>Forenübersicht über das aktuelle Geschehen.</p>
		<table>
			<tr>
				<td style="width: 70%;">Forum</td>
				<td>Letzter Beitrag</td>
			</tr>
			<?php foreach($app->forums as $forum): ?>
			<tr>
				<td>
					<a href="<?=$app->path; ?>/forum/<?=$forum->id; ?>"><?=$forum->name; ?></a>
				</td>
				
				<td>
					<a href="<?=$app->path; ?>">Link</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		