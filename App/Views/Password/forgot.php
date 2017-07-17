<!DOCTYPE html>
<html lang="en">
<head>
	<?php require 'App/Views/Partials/header.php'; ?>
    <title>Forgotten password</title>
</head
<body>
	<?php require 'App/Views/Partials/nav.php'; ?>

	<h1>Reset your password</h1>

	<form method="post" action="/password/request-reset">
		<div>
		        <label for="inputEmail">Email address</label>
		        <input id="inputEmail" name="email" placeholder="Email address" type="email" required >
		</div>
		<button type="submit">Send password reset</button>
	</form>

	<?php require 'App/Views/Partials/footer.php'; ?>
</body>
</html>
