<!DOCTYPE html>
<html lang="en">
<head>
	<?php require 'App/Views/Partials/header.php'; ?>
	<link rel="stylesheet" href="/public/css/montage.css">
	<title>Take a picture</title>
</head
<body>
	<?php require 'App/Views/Partials/nav.php'; ?>
	<?php require 'App/Views/Partials/flash.php'; ?>

	<h1>Take a new picture</h1>

	<div class="container">
		<div class="app">

		  <a href="#" id="start-camera" class="visible">Touch here to start the app.</a>
		  <video id="camera-stream"></video>
		  <img id="snap">
		  <img id="overlay-filter">

		  <p id="error-message"></p>

		  <div class="controls">
			<a href="#" id="delete-photo" title="Delete Photo" class="disabled"><i class="material-icons">clear</i></a>
			<a href="#" id="take-photo" title="Take Photo"><i class="material-icons">camera_alt</i></a>
			<a href="#" id="download-photo" title="Save Photo" class="disabled"><i class="material-icons">done</i></a>  
			<!-- <a href="#" id="download-photo" download="selfie.png" title="Save Photo" class="disabled"><i class="material-icons">done</i></a> --> 
		  </div>



		  <!-- Hidden canvas element. Used for taking snapshot of video. -->
		  <canvas></canvas>
		</div>
		<div class="filter">	
			<?php foreach ($filters as $filter): ?>
			<img src="public/img/<?= basename($filter) ?>" id="<?= basename($filter) ?>"alt="Glasses" width="40px" class="emoji">
			<?php endforeach; ?>
		</div>	
	</div>	
		<!--
		<form id="file-form" action="handler.php" method="POST">
		  <input type="file" id="file-select" name="photos[]" />
		  <button type="submit" id="upload-button">Upload</button>
		</form>
		-->
	<div id="image-upload">
		<input type="file" id="image-loader" name="image-loader" accept="image/*" onchange="loadFile(event)"/>
	</div>
	<div id="user_photos">

		<?php if ($gallery_photos): ?>	
		<?php foreach ($gallery_photos as $photo): ?>
				<img src="uploads/<?= $photo['src'] ?>">
			<?php endforeach; ?>
		<?php endif; ?>	

	</div>

	<?php require 'App/Views/Partials/footer.php'; ?>
	<script src="/public/js/montage.js"></script>
</body>
</html>
