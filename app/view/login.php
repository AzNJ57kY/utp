		<h2>Anmelden</h2>
		<p>Bitte gebe Zugansdaten ein um Zugriff auf die Plattform zu erhalten.</p>
		<?=$app->message; ?>
		<form method="post">
			<label for="name">Benutzername</label>
			<input type="text" name="name" id="name" placeholder="BsP. test">
			<label for="password">Passwort</label>
			<input type="password" name="password" id="password" placeholder="*****">
			<input type="submit" value="Login">
		</form>
		