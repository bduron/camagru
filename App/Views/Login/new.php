<!DOCTYPE html>
<html lang="en">
<head>
	<?php require 'App/Views/Partials/header.php'; ?>
    <title>Login</title>
</head
<body>
	<?php require 'App/Views/Partials/nav.php'; ?>
	<?php require 'App/Views/Partials/flash.php'; ?>

	<div class="form-box">
		
		<h1>Login</h1>

		<?php if (!empty($user->errors)): ?>
			<p>Errors :</p>
			<ul>
			<?php foreach ($user->errors as $error): ?>
				<li><?= $error ?></li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php $name = (isset($name)) ? $name : ""; ?>

		<form method="post" action="/login/create">
			<div>
					<input class="form-input" id="inputName" name="name" placeholder="Name" value="<?= h($name) ?>" autofocus required /> 
			</div>
			<div>
					<input class="form-input" id="inputPassword" type="password" name="password" placeholder="Password">
			</div>
			<div>
				<label for="remember_me">
					<input type="checkbox" name="remember_me" <?= $remember_me ?? "" ?> /> Remember me
				</label>
			</div>
			<button class="form-button" type="submit">Log in</button>
			<br><a href="/password/forgot">Forgot password ?</a>
		</form>
	</div>
	<?php require 'App/Views/Partials/footer.php'; ?>
</body>
</html>
