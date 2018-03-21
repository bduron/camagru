<!DOCTYPE html>
<html lang="en">
<head>
	<?php require 'App/Views/Partials/header.php'; ?>
	<link rel="stylesheet" href="/public/css/home.css">
    <title>Home</title>
</head
<body>
	<?php require 'App/Views/Partials/nav.php'; ?>
	<?php require 'App/Views/Partials/flash.php'; ?>
		
	<div class="main">
		<div id="user_photos">
			<?php require 'App/Views/Partials/photo.php'; ?>
		</div>
	</div>
<?php if ($user): ?>
	<div class="current-user">
		<?= $user->name ?>
	</div>
<?php endif; ?>

	<?php require 'App/Views/Partials/footer.php'; ?>
</body>
</html>
