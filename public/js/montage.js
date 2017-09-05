// References to all the element we will need.
var video = document.querySelector('#camera-stream'),
	image = document.querySelector('#snap'),
	start_camera = document.querySelector('#start-camera'),
	controls = document.querySelector('.controls'),
	take_photo_btn = document.querySelector('#take-photo'),
	delete_photo_btn = document.querySelector('#delete-photo'),
	download_photo_btn = document.querySelector('#download-photo'),
	error_message = document.querySelector('#error-message');
	upload_status = document.querySelector('#upload-status');
	canvas = document.querySelector('canvas');


// The getUserMedia interface is used for handling camera input.
// Some browsers need a prefix so here we're covering all the options
navigator.getMedia = ( navigator.getUserMedia ||
				navigator.webkitGetUserMedia ||
				navigator.mozGetUserMedia ||
				navigator.msGetUserMedia);


if(!navigator.getMedia){
		displayErrorMessage("Your browser doesn't have support for the navigator.getUserMedia interface.");
}
else{

		// Request the camera.
		navigator.getMedia(
						{
								video: true
						},
						// Success Callback
						function(stream){

								// Create an object URL for the video stream and
								// set it as src of our HTLM video element.
								video.src = window.URL.createObjectURL(stream);

								// Play the video element to start the stream.
								video.play();
								video.onplay = function() {
										showVideo();
								};

						},
						// Error Callback
						function(err){
								displayErrorMessage("There was an error with accessing the camera stream: " + err.name, err);
						}
		);

}



// Mobile browsers cannot play video without user input,
// so here we're using a button to start it manually.
start_camera.addEventListener("click", function(e){

		e.preventDefault();

		// Start video playback manually.
		video.play();
		showVideo();

});


take_photo_btn.addEventListener("click", function(e){

		e.preventDefault();

		var snap = takeSnapshot();

		// Show image. 
		image.setAttribute('src', snap);
		image.classList.add("visible");

		// Enable delete and save buttons
		delete_photo_btn.classList.remove("disabled");
		download_photo_btn.classList.remove("disabled");

		// Set the href attribute of the download button to the snap url.
//		download_photo_btn.href = snap;

		// Pause video playback of stream.
		video.pause();

});

download_photo_btn.addEventListener("click", function(e) {

	// Create a new FormData object.
	var form_data = new FormData();	

	// Create photo blob
	canvas.toBlob(function(blob) {
		var	photo_blob = blob;
		
		form_data.append('photo', photo_blob, 'photo.png');

		// Set up Ajax request 
		var request = new XMLHttpRequest();
		
		// Open the connection
		request.open('POST', 'montage/upload', true);

		// Set up a handler for when the request finishes
		request.onload = function () {
			if (request.status === 200) 
			{
		    	alert('Photo uploaded to the server');
				console.log(request.responseText);
			}
			else 
		    	alert('An error occurred!');
		};	

		// Send the Data.
		request.send(form_data);

	//	console.log(photo_blob);

	});



});


delete_photo_btn.addEventListener("click", function(e){

		e.preventDefault();

		// Hide image.
		image.setAttribute('src', "");
		image.classList.remove("visible");

		// Disable delete and save buttons
		delete_photo_btn.classList.add("disabled");
		download_photo_btn.classList.add("disabled");

		// Resume playback of stream.
		video.play();

});



function showVideo(){
		// Display the video stream and the controls.

		hideUI();
		video.classList.add("visible");
		controls.classList.add("visible");
}


function takeSnapshot(){
		// Here we're using a trick that involves a hidden canvas element.  

		var hidden_canvas = document.querySelector('canvas'),
		context = hidden_canvas.getContext('2d');

		var width = video.videoWidth,
		height = video.videoHeight;

		if (width && height) {

				// Setup a canvas with the same dimensions as the video.
				hidden_canvas.width = width;
				hidden_canvas.height = height;

				// Make a copy of the current frame in the video on the canvas.
				context.drawImage(video, 0, 0, width, height);


				// Turn the canvas image into a dataURL that can be used as a src for our photo.
				return hidden_canvas.toDataURL('image/png');
		}
}


function displayErrorMessage(error_msg, error){
		error = error || "";
		if(error){
				console.log(error);
		}

		error_message.innerText = error_msg;

		hideUI();
		error_message.classList.add("visible");
}


function hideUI(){
		// Helper function for clearing the app UI.

		controls.classList.remove("visible");
		start_camera.classList.remove("visible");
		video.classList.remove("visible");
		snap.classList.remove("visible");
		error_message.classList.remove("visible");
}


//// Grab elements, create settings, etc.
//var video = document.getElementById('video');
//
//// Get access to the camera!
//if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
//{
//		// Not adding `{ audio: true }` since we only want video now
//		navigator.mediaDevices.getUserMedia({ video: true }).then( function(stream) {
//				video.src = window.URL.createObjectURL(stream);
//				video.play(); });
//}	
//
//// Elements for taking the snapshot
//var canvas = document.getElementById('canvas');
//var context = canvas.getContext('2d');
//var video = document.getElementById('video');
//
//// Trigger photo take
//document.getElementById("snap").addEventListener("click", function() {
//		context.drawImage(video, 0, 0, 640, 480);
//});
