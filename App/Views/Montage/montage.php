<!DOCTYPE html>
<html lang="en">
<head>
	<?php require 'App/Views/Partials/header.php'; ?>
    <title>Take a picture</title>
</head
<body>
	<?php require 'App/Views/Partials/nav.php'; ?>
	<?php require 'App/Views/Partials/flash.php'; ?>
	<h1>Take a new picture</h1>

	<video id="video" width="640" height="480" autoplay></video>
	<button id="snap">Snap Photo</button>
	<canvas id="canvas" width="640" height="480"></canvas>

	<?php require 'App/Views/Partials/footer.php'; ?>

	<script>
		// Grab elements, create settings, etc.
 		var video = document.getElementById('video');

		// Get access to the camera!
		if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
		{
     		// Not adding `{ audio: true }` since we only want video now
			navigator.mediaDevices.getUserMedia({ video: true }).then( function(stream) {
                 video.src = window.URL.createObjectURL(stream);
                 video.play(); });
        }	
	</script>

	<script>
		// Elements for taking the snapshot
		var canvas = document.getElementById('canvas');
		var context = canvas.getContext('2d');
		var video = document.getElementById('video');
		
		// Trigger photo take
		document.getElementById("snap").addEventListener("click", function() {
			context.drawImage(video, 0, 0, 640, 480);
			});
	</script>

</body>
</html>
