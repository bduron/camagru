<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../App/Views/Partials/header.php'; ?>
    <title>Home</title>
</head
<body>
	<?php require '../App/Views/Partials/nav.php'; ?>
	<h1>Camagru</h1>
		<?php  if(\App\Auth::isLoggedIn()): ?>
			<p>Hello <?= $user->name ?>. <a href="/logout">Log out</a> </p>
		<?php else: ?>
			<p>Welcome to the funniest photo editor of the Web</p> 
		<?php  endif;?>
	<?php require '../App/Views/Partials/footer.php'; ?>
</body>
</html>
