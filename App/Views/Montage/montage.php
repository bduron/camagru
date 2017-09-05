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
		<div>	
			<?php foreach ($filters as $filter): ?>
				<img src="public/img/<?= basename($filter) ?>" alt="Glasses" width="100px">
			<?php endforeach; ?>
		</div>	
	</div>	

	<?php require 'App/Views/Partials/footer.php'; ?>
	<script src="/public/js/montage.js"></script>
</body>
</html>
