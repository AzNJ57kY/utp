		<h2>Thema: <?=$app->topic->title; ?></h2>
		<p>Beiträge zum ausgewählten Thema.</p>
		<?php foreach($app->posts as $post): ?>
		<article><?=$post->content; ?></article>
		<?php endforeach; ?>
		