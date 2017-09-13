<!DOCTYPE html>
<html lang="en">
<head>
	<?php require 'App/Views/Partials/header.php'; ?>
    <title>Sign up</title>
</head
<body>
	<?php require 'App/Views/Partials/nav.php'; ?>

	<div class="signup form-box">
		<h1>Sign up</h1>
		<h2>Sign up to see photos and videos from your friends.</h2>

		<?php if (!empty($user->errors)): ?>
			<p>Errors :</p>
			<ul>
			<?php foreach ($user->errors as $error): ?>
				<li><?= $error ?></li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php $name = (isset($user->name)) ? $user->name : ""; ?>
		<?php $email = (isset($user->email)) ? $user->email : ""; ?>

		<form method="post" action="/signup/create">
			<div>
					<input class="form-input" id="inputName" name="name" placeholder="Name" autofocus value="<?= h($name) ?>" required /> 
			</div>
			<div>
					<input class="form-input" id="inputEmail" name="email" placeholder="Email address" value="<?= h($email) ?>" type="email" required >
			</div>
			<div>
					<input class="form-input" id="inputPassword" type="password" name="password" placeholder="Password" required>
			</div>
			<div>
					<input class="form-input" id="inputPasswordConfirm" type="password" name="password_confirm" placeholder="Repeat password" required>
			</div>
			<button class="form-button" type="submit">Sign up</button>
		</form>
	</div>

	<div class="form-box">
	<p>Have an account ? <a href="/login">Log in</a> </p>
	</div>
	<?php require 'App/Views/Partials/footer.php'; ?>
</body>
</html>
