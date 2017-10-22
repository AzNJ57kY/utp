<?php
	require_once './app/app.php';
	require_once app::initApp()[0];

	$app = new app::$init[2];
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$app->name; ?> - <?=$app->title; ?></title>
	<meta charset="utf-8">
	<link href="<?=$app->path; ?>/main.css" rel="stylesheet">
</head>

<body>
	<header>
		<h2><?=$app->name; ?></h2>
		<nav>
			<a href="<?=$app->path; ?>">Home</a>
		</nav>
	</header>
	<main>
<?php
	require_once app::$init[1];
?>
	</main>
</body>
</html>