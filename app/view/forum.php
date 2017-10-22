		<h2>Forum: <?=$app->forum->name; ?></h2>
		<p>Alle verfügbaren Themen aus dem ausgewählten Forum.</p>
		<table>
			<tr>
				<td>Thema</td>
				<td style="width: 15%;">Datum</td>
			</tr>
			<?php if (is_array($app->topics)): ?>
			<?php foreach($app->topics as $topic): ?>
			<tr>
				<td>
					<a href="<?=$topic->path; ?>"><?=$topic->title; ?></a>
				</td>
				<td><?=$topic->date; ?></td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td>Keine Themen vorhanden.</td>
				<td>-</td>
			</tr>
			<?php endif; ?>
		</table>
		