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
		<?php endif; ?>
		</form>
		