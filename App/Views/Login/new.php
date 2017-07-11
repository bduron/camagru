<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../App/Views/Partials/header.php'; ?>
    <title>Login</title>
</head
<body>
	<?php require '../App/Views/Partials/nav.php'; ?>

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
		        <label for="inputName">Username</label>
				<input id="inputName" name="name" placeholder="Name" value="<?= h($name) ?>" autofocus required /> 
		</div>
		<div>
		        <label for="inputPassword">Password</label>
		        <input id="inputPassword" type="password" name="password" placeholder="Password">
		</div>
		<button type="submit">Log in</button>
	</form>

	<?php require '../App/Views/Partials/footer.php'; ?>
</body>
</html>
