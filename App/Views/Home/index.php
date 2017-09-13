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
			<?php if ($photos): ?>
				<?php foreach ($photos as $photo): ?>

					<div class="container">
						<div class="card">
							<div class="header">
								<p><b>benjaminduron</b></p>
								<p>France, Paris</p>
							</div>
							<div class="photo">
								<img src="<?= 'uploads/' . $photo['src'] ?>" alt="">
							</div>
							<div class="comments">
								<div class="like">
									<p><i class="material-icons">favorite_border</i>  19 likes <span class="time">2 DAYS AGO</span></p>
								</div>
								<div class="coms">
									<p class="com"><b>moneytime</b> Trop belle photoooo 😍</p>
									<p class="com"><b>justiceantlr</b> Green juice venmo readymade heirloom shabby chic, four loko.</p>
								</div>
								<div class="write">
									<form action="">
										<textarea id="" name="" cols="30" rows="10" placeholder="Write your comment" ></textarea>
									</form>
								</div>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>

	<?php require 'App/Views/Partials/footer.php'; ?>
</body>
</html>
