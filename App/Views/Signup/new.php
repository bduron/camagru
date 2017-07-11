<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../App/Views/Partials/header.php'; ?>
    <title>Sign up</title>
</head
<body>
	<?php require '../App/Views/Partials/nav.php'; ?>

	<h1>Sign up</h1>

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
		        <label for="inputName">Name</label>
				<input id="inputName" name="name" placeholder="Name" autofocus value="<?= h($name) ?>" required /> 
		</div>
		<div>
		        <label for="inputEmail">Email</label>
		        <input id="inputEmail" name="email" placeholder="Email address" value="<?= h($email) ?>" type="email" required >
		</div>
		<div>
		        <label for="inputPassword">Password</label>
		        <input id="inputPassword" type="password" name="password" placeholder="Password" required>
		</div>
		<div>
		        <label for="inputPasswordConfirm">Repeat password</label>
		        <input id="inputPasswordConfirm" type="password" name="password_confirm" placeholder="Repeat password" required>
		</div>
		<button type="submit">Sign up</button>
	</form>

	<?php require '../App/Views/Partials/footer.php'; ?>
</body>
</html>
