<!DOCTYPE html>
<html lang="en">
<head>
	<?php require 'App/Views/Partials/header.php'; ?>
    <title>Profile</title>
</head
<body>
	<?php require 'App/Views/Partials/nav.php'; ?>
	<?php require 'App/Views/Partials/flash.php'; ?>

	<div class="signup form-box">
		<h1>Profile</h1>

		<?php $name = (isset($user->name)) ? $user->name : ""; ?>
		<?php $email = (isset($user->email)) ? $user->email : ""; ?>

		<form method="post" action="/profile/update-profile">
			<div>
					<input class="form-input" id="inputName" name="name" placeholder="Name" autofocus value="<?= h($name) ?>" required /> 
			</div>
			<div>
					<input class="form-input" id="inputEmail" name="email" placeholder="Email address" value="<?= h($email) ?>" type="email" required >
			</div>
			<button class="form-button" type="submit">Update my profile</button>
		</form>
	</div>

	<div class="signup form-box">
		<form method="post" action="/profile/update-password">
			<div>
					<input class="form-input" id="inputPassword" type="password" name="password" placeholder="New password">
			</div>
			<div>
					<input class="form-input" id="inputPasswordConfirm" type="password" name="password_confirm" placeholder="Repeat password" >
			</div>
			<button class="form-button" type="submit">Update my password</button>
		</form>
	</div>

	<div class="signup form-box">
		<form method="post" action="/profile/update-notifications">
			<p>Would you like to be notified when someone comments your photos?</p>
			<br>
			  <div>
				<input type="radio" id="yes"
				name="notifications" value="1" <?= $user->notifications ? 'checked' : '' ?> >
				<label for="yes">Yes</label>

				<input type="radio" id="no"
				 name="notifications" value="0" <?= $user->notifications ? '' : 'checked' ?> > 
				<label for="no">No</label>

			  </div>
			  <div>
				<button class="form-button" type="submit">Update preferences</button>
			  </div>
		</form>
	</div>

	<?php require 'App/Views/Partials/footer.php'; ?>
</body>
</html>
