		<h2>Foren</h2>
		<p>Forenübersicht über das aktuelle Geschehen.</p>
		<table>
			<tr>
				<td style="width: 70%;">Forum</td>
				<td>Letztes Thema</td>
			</tr>
			<?php foreach($app->forums as $forum): ?>
			<tr>
				<td>
					<a href="<?=$app->path; ?>/forum/<?=$forum->hash; ?>"><?=$forum->name; ?></a>
				</td>
				
				<td>
					<?php if (is_object($forum->last)): ?>
					<a href="<?=$app->path; ?>/topic/<?=$forum->last->id; ?>"><?=$forum->last->title; ?></a>
					<?php else: ?>
					<?=$forum->last; ?>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		