		<h2>Editor</h2>
		<p>Vorhandene Beiträge/Themen editieren oder neu erstellen.</p>
		<?=$app->message; ?>
		<form method="post">
			<input type="hidden" name="token" value="<?=$_SESSION['user']['token']; ?>">
		<?php if ($app->mode === 1): ?>
			<label for="title">Titel</label>
			<input type="text" name="title" id="title">
			<label for="content">Inhalt des neuen Themas</label>
			<textarea name="content" id="content"></textarea>
			<input type="submit" value="Erstellen">
		<?php elseif ($app->mode === 2): ?>
			<label for="content">
					Beitrag zum Thema: 
					<a href="<?=$app->path; ?>/topic/<?=$app->topic->id; ?>" target="_blank" rel="noopener noreferer"><?=$app->topic->title; ?></a>
			</label>
			<textarea name="content" id="content"></textarea>
			<input type="submit" value="Erstellen">
		<?php elseif ($app->mode === 3): ?>
			<label for="content">
					Editierung zum Thema: 
					<a href="<?=$app->path; ?>/topic/<?=$app->topic->id; ?>" target="_blank" rel="noopener noreferer"><?=$app->topic->title; ?></a>
			</label>
			<textarea name="content" id="content"><?=$app->post->content; ?></textarea>
			<input type="submit" value="Bearbeiten">
		<?php elseif ($app->mode === 4): ?>
			<label for="title">Titel editieren</label>
			<input type="text" name="title" id="title" value="<?=$app->topic->title; ?>">
			<input type="submit" value="Bearbeiten">
		<?php endif; ?>
		</form>
		<script>
			$(function() {
				$("#content").wysibb();
			});
		</script>
		