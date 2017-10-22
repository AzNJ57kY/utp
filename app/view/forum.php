		<h2>Forum: <?=$app->forum->name; ?></h2>
		<p>Alle verfügbaren Themen aus dem ausgewählten Forum.</p>
		<nav>
			<a href="<?=$app->path; ?>/editor/ct/<?=app::$objRoute[1]; ?>">Thema erstellen</a>
		</nav>
		<table>
			<tr>
				<td>Thema</td>
				<td style="width: 10%;">Autor</td>
				<td style="width: 15%;">Datum</td>
			</tr>
			<?php if (is_array($app->topics)): ?>
			<?php foreach($app->topics as $topic): ?>
			<tr>
				<td>
					<a href="<?=$topic->path; ?>"><?=$topic->title; ?></a>
				</td>
				<td>
					<a href="<?=$topic->path; ?>"><?=$topic->author; ?></a>
				</td>
				<td><?=$topic->date; ?></td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td>Keine Themen vorhanden.</td>
				<td>-</td>
				<td>-</td>
			</tr>
			<?php endif; ?>
		</table>
		