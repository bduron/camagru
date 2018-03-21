window.onload = function() {

	var alerts = document.querySelectorAll('.alert'),
		comment_form = document.querySelectorAll('.comment-form'), 
		form_text = document.querySelectorAll('.form-text'),
		like_buttons = document.querySelectorAll('.like-btn'),
		current_user = document.querySelector('.current-user');

		
	/****************************  INFINITE SCROLL FUNCTION  ********************************/
	

	function photoOnload(request) {
		if (request.status === 200) { 
			let photosElem = document.querySelector('#user_photos');
			photosElem.innerHTML = photosElem.innerHTML + request.responseText;
			reloadEventListeners();
		} else 
			console.log('An error occurred!');
	}

	function photoAjax() {

		/* Get last photo index */
		let photos = document.querySelectorAll('.photo');
		let last_id = photos[photos.length - 1].id;
		var data = `last_id=${last_id}`;

		/* Prepare and send request */
		var request = new XMLHttpRequest();
		request.open('GET', `home/get-photos?${data}`, true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.onload = () => photoOnload(request);
		request.send(null);
	}

	function debounce(func, wait = 100) {
		let timeout;
		return function(...args) {
			clearTimeout(timeout);
			timeout = setTimeout(() => {
				func.apply(this, args);
			}, wait);
		};
	}

	function reloadEventListeners() {
		document.querySelectorAll('.comment-form')
			.forEach(x => x.addEventListener("submit", commentEventListener));

		document.querySelectorAll('.form-text')
			.forEach(x => {
				x.onkeydown = function(e) {
					if (e.keyCode == 13) {
						e.preventDefault();
						e.target.closest('.comment-form').elements[3].click();
					}
				}
			});

		document.querySelectorAll('.like-btn')
			.forEach(x => x.addEventListener('click', likeEventListner));	
	}

	function resetEventListeners() {
		document.querySelectorAll('.form-text')
			.forEach(x => x.removeEventListener("submit", commentEventListener));

		document.querySelectorAll('.like-btn')
			.forEach(x => x.removeEventListener('click', likeEventListner));	
	}

	function getDistFromBottom () {

		console.log('called');	

		var scrollPosition = window.pageYOffset;
		var windowSize     = window.innerHeight;
		var bodyHeight     = document.body.offsetHeight;

		const res = Math.max(bodyHeight - (scrollPosition + windowSize), 0);

		if (res == 0 && window.location.href.split('/').pop() == "") {
			console.log('load more');
			resetEventListeners();	
			photoAjax();
		}
	}
	
	var debounced = debounce(getDistFromBottom, 500);

	window.addEventListener('scroll', function() {
		debounced();
	});


	/****************************  LIKES FUNCTION  ********************************/

	
	function likeAjax(e, action) {
		var request = new XMLHttpRequest();

		request.open('POST', `likes/${action}`, true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		request.onload = function () {
			if (request.status === 200) 
				console.log(`like ${action} request sent `);
			else 
				console.log('An error occurred!');
		}

		var data = 'image_id=' + Number(e.target.parentNode.parentNode.id);

		request.send(data);
	}

	function incrementLike(e) {
		let count = Number(e.target.parentNode.children[1].innerText);
		e.target.parentNode.children[1].innerText = count + 1; 
	}

	function decrementLike(e) {
		let count = Number(e.target.parentNode.children[1].innerText);
		e.target.parentNode.children[1].innerText = count - 1; 
	}

	function isLiked(e) {
		return e.target.className.includes('liked');
	}

	function toggleLike(e) {
		if (isLiked(e))
			e.target.classList.remove('liked');
		else 
			e.target.classList.add('liked');
	}

	function likeEventListner(e) {
		e.preventDefault();
		if (isLiked(e)) {
			likeAjax(e, 'remove');
			toggleLike(e);
			decrementLike(e);
		} else {
			likeAjax(e, 'add');
			toggleLike(e);
			incrementLike(e);
		}
	}	

	if (like_buttons) {
		like_buttons.forEach(btn => {
			if (current_user != null) 
				btn.addEventListener("click", likeEventListner);
		});
	}



	/****************************  COMMENTS FUNCTION  ********************************/

	if (form_text)
	{
		form_text.forEach(function(elem) {
			elem.onkeydown = function(e) {
				if (e.keyCode == 13)
				{
					e.preventDefault();
					e.target.closest('.comment-form').elements[3].click();
				}
			}
		});
	}

	function commentEventListener(e) {
		e.preventDefault();

		var request = new XMLHttpRequest();

		request.open('POST', 'comments/add', true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		request.onload = function () {
			if (request.status === 200) 
				console.log(request.responseText);
			else 
			{
				alert('An error occurred!');
				console.log(request.responseText);
			}
		}

		var data = 	'comment=' + e.target.elements[0].value
			+ '&image_id=' + e.target.elements[1].value;
		//	+ '&user_id=' + e.target.elements[2].value;

		request.send(data);


		/* Reset input field & display the comment */

		var comment = document.createElement("P");
		var user = document.createElement("B");
		user.appendChild(document.createTextNode(document.querySelector('.current-user').innerHTML));	

		var text = e.target.elements[0].value;
		text = document.createTextNode(text);

		comment.appendChild(user);	
		comment.appendChild(text);	
		comment.className = "com";
		e.target.closest('div').previousElementSibling.appendChild(comment);
		e.target.elements[0].value = "";
	}

	if (comment_form)
	{
		comment_form.forEach(function(elem) {
			elem.addEventListener("submit", commentEventListener);
		});
	}

	
	/****************************  FLASH FUNCTION  ********************************/

	function removeFlash(e) {
		e.preventDefault();
		if (e.target.nodeName == 'I')
			e.target.parentNode.remove();
	}

	if (alerts) {	
		alerts.forEach(alert => {
			alert.addEventListener("click", removeFlash)
		});
	}

}
