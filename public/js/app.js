window.onload = function() {

	var alerts = document.querySelectorAll('.alert'),
		comment_form = document.querySelectorAll('.comment-form'), 
		form_text = document.querySelectorAll('.form-text');
		like_buttons = document.querySelectorAll('.like-btn');

		
	/****************************  LIKES FUNCTION  ********************************/

	
	function likeAjax(e, action) {
		var request = new XMLHttpRequest();

		request.open('POST', `likes/${action}`, true);
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


	if (like_buttons) {
		like_buttons.forEach(btn => {
			btn.addEventListener("click", e => {
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
			});	
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


	if (comment_form)
	{
		comment_form.forEach(function(elem) {
			elem.addEventListener("submit", function(e) {
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
			
			});
		});
	}

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
