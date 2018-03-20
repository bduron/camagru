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
							<p><b><?= h($photo['name']) ?></b></p>
								<p>France, Paris</p>
							</div>
							<div class="photo" id="<?= $photo['id'] ?>">
								<img src="<?= 'uploads/' . $photo['src'] ?>" alt="">
							</div>
							<div class="comments">

								<div class="like">
									<?php if (ISSET($userLikes[$photo['id']])): ?>
									<p><i class="material-icons">favorite</i>  <?= $allLikes[$photo['id']]?> likes <span class="time"></span></p>
									<?php else: ?>
										<p>
											<i class="material-icons">favorite_border</i>  
											<?= ISSET($allLikes[$photo['id']]) ? $allLikes[$photo['id']] : 0 ?> likes <span class="time"></span>
										</p>
									<?php endif; ?>
								</div>

								<div class="coms">
									<?php foreach ($comments->getComments($photo['id']) as $comment): ?>		
										<p class="com"><b> <?= h($comment['name']) ?>  </b> <?= h($comment['comment']) ?> </p>
									<?php endforeach; ?>
								</div>
							<?php if ($user): ?>
								<div class="write">
									<form class="comment-form" action="">
										<textarea class="form-text" id="" name="" cols="30" rows="10" placeholder="Write your comment" ></textarea>
										<input type="hidden" name="image_id" value="<?= $photo['id'] ?>">
										<input type="hidden" name="user_id" value="<?= $user->id ?>">
										<button class="form-button" name="form-button" type="submit">Submit</button>
									</form>
								</div>
							<?php else: ?>
								<div class="write">
									<form class="comment-form" action="">
										<textarea class="form-text" id="" name="" cols="30" rows="10" placeholder="Write your comment (log in to comment)" disabled></textarea>
									</form>
								</div>
							<?php endif; ?>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			<?php endif; ?>
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
