// References to all the element we will need.
var video = document.querySelector('#camera-stream'),
	image = document.querySelector('#snap'),
	start_camera = document.querySelector('#start-camera'),
	controls = document.querySelector('.controls'),
	take_photo_btn = document.querySelector('#take-photo'),
	delete_photo_btn = document.querySelector('#delete-photo'),
	download_photo_btn = document.querySelector('#download-photo'),
	error_message = document.querySelector('#error-message'),
	upload_status = document.querySelector('#upload-status'),
	canvas = document.querySelector('canvas'),
	filters = document.querySelector('.filter'),
	default_filter = document.querySelector('.filter>img'),
	overlay_filter = document.querySelector('#overlay-filter'),
    image_loader = document.querySelector('#image-loader'),
	gallery_photo = document.querySelector('#user_photos'),
	current_blob = 0;


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

		//var snap = takeSnapshotBlob();
		takeSnapshotBlob();

		// Show image. 
		//image.setAttribute('src', snap);
		image.classList.add("visible");

		// Enable delete and save buttons
		delete_photo_btn.classList.remove("disabled");
		download_photo_btn.classList.remove("disabled");

		// Pause video playback of stream.
		video.pause();

});

download_photo_btn.addEventListener("click", function(e) {

	// Create a new FormData object.
	var form_data = new FormData();	

	// Create photo blob
	console.log(image.src);
	var	photo_blob = current_blob;
	var current_filter_id = document.querySelector('.filter>img.selected-filter').id;

	form_data.append('photo', photo_blob, 'photo.png');
	form_data.append('filter_id', current_filter_id);

	// Set up Ajax request 
	var request = new XMLHttpRequest();
	
	// Open the connection
	request.open('POST', 'montage/upload', true);

	// Set up a handler for when the request finishes
	request.onload = function () {
		if (request.status === 200) 
		{
			//alert('Photo uploaded to the server');
			var img_src = request.responseText;
			console.log("img src = " + img_src); // Debug 
			
			var img_to_add = document.createElement("img");
			img_to_add.src = img_src;

			var img_dest = document.querySelector('#user_photos');
			img_dest.appendChild(img_to_add);

		}
		else 
			alert('An error occurred!');
	};	

	// Send the Data.
	request.send(form_data);

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


// Activate the default filter 
default_filter.setAttribute('class', "selected-filter");
overlay_filter.setAttribute('src', document.querySelector('.filter>img.selected-filter').src);


filters.addEventListener("click", function(e){

		e.preventDefault();
		
		console.log(e.target);
		if (e.target.nodeName == 'IMG' && download_photo_btn.className == "disabled")
		{	
			var current_filter = document.querySelector('.filter>img.selected-filter');
			current_filter.classList.remove("selected-filter");
			var image = e.target;
			image.setAttribute('class', "selected-filter");
			var overlay = document.querySelector('.filter>img.selected-filter').src;
			overlay_filter.setAttribute('src', overlay);
			//overlay_filter.image.classList.add("visible");
		}

	//download_photo_btn.classList.add("disabled");
});


// DELETE gallery photos when clicking on them 
gallery_photo.addEventListener("click", function(e){

	e.preventDefault();
	
	if (e.target.nodeName == 'IMG')
	{
		alert(e.target.src);		
			
		// Set up Ajax request 
		var request = new XMLHttpRequest();
		
		// Open the connection
		request.open('POST', 'montage/delete', true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		request.onload = function () {
			if (request.status === 200) 
			{
//				alert('Photo deleted');
				console.log(request.responseText);
			}
			else 
			{
				alert('An error occurred!');
				console.log(request.responseText);
			}
		}
		var name = 'src=' + e.target.src.split('/')[4];
//		console.log(name);
		request.send(name);
		e.target.remove();
	}

});


var loadFile = function(event) {
	if (event.target.files[0])
	{
		var output = document.getElementById('snap');
		current_blob = event.target.files[0];
		output.src = URL.createObjectURL(event.target.files[0]);

		output.classList.add("visible");

		// Enable delete and save buttons
		delete_photo_btn.classList.remove("disabled");
		download_photo_btn.classList.remove("disabled");

		// Pause video playback of stream.
		video.pause();
		controls.classList.add("visible"); // supprimer le take snapshot ?
	}
};

function showVideo(){
		// Display the video stream and the controls.

		hideUI();
		video.classList.add("visible");
		controls.classList.add("visible");
}

function takeSnapshotBlob(){
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

				
				hidden_canvas.toBlob(function(blob) {
					current_blob = blob;

					var url = URL.createObjectURL(blob);
					var image = document.querySelector('#snap');
					image.src = url;
				});
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


