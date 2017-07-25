<!DOCTYPE html>
<html lang="en">
<head>
	<?php require 'App/Views/Partials/header.php'; ?>
    <title>Reset password</title>
</head
<body>
	<?php require 'App/Views/Partials/nav.php'; ?>

	<h1>Reset your password</h1>

	<?php if (!empty($user->errors)): ?>
		<p>Errors :</p>
		<ul>
		<?php foreach ($user->errors as $error): ?>
			<li><?= $error ?></li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<form method="post" action="/password/reset-password">
	<input type="hidden" name="token" value="<?= $token ?>">
		<div>
		        <label for="inputPassword">Password</label>
		        <input id="inputPassword" type="password" name="password" placeholder="Password" required>
		</div>
		<div>
		        <label for="inputPasswordConfirm">Repeat password</label>
		        <input id="inputPasswordConfirm" type="password" name="password_confirm" placeholder="Repeat password" required>
		</div>
		<button type="submit">Reset password</button>
	</form>

	<?php require 'App/Views/Partials/footer.php'; ?>
</body>
</html>
