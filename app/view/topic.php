		<h2>Thema: <?=$app->topic->title; ?></h2>
		<p>Beiträge zum ausgewählten Thema.</p>
		<nav>
			<a href="<?=$app->path; ?>/editor/cp/<?=app::$objRoute[1]; ?>">Beitrag erstellen</a>
		</nav>
		<?php foreach($app->posts as $post): ?>
		<article>
			<p>Autor: <?=$post->author; ?> | <?=$post->date; ?></p>
			<?=$post->content; ?>
			<nav>
				<a href="">Bearbeiten</a>
			</nav>
		</article>
		<?php endforeach; ?>
		