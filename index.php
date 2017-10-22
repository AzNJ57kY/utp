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
	<link href="<?=$app->path; ?>/app/libs/editor/theme/default/wbbtheme.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="<?=$app->path; ?>/app/libs/editor/jquery.wysibb.js"></script>
</head>

<body>
	<header>
		<a href="<?=$app->path; ?>">
			<h2><?=$app->name; ?></h2>
			<p>Your place for confidential discussion.</p>
		</a>
		<div>
			<?php if ($app->checkSession()): ?>
			<nav>
				<a href="<?=$app->path; ?>">Forum</a>
				<a href="<?=$app->path; ?>/logout">Logout [ <?=$app->filter($_SESSION['user']['name']); ?> ]</a>
			</nav>
			<?php else: ?>
			<nav>
				<a href="<?=$app->path; ?>/login">Login</a>
			</nav>
			<?php endif; ?>
		</div>
	</header>
	<main>
<?php
	require_once app::$init[1];
?>
	</main>
</body>
</html>