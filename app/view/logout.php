		<h2>Abmelden</h2>
		<p>Cookies/Session löschen durch das Abmelden über den Button.</p>
		<form method="post">
			<input type="hidden" name="token" value="<?=$_SESSION['user']['token']; ?>">
			<input type="submit" value="Logout">
		</form>
		