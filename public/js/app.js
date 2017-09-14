window.onload = function() {

	var alert_box = document.querySelector('.alert'),
		comment_form = document.querySelectorAll('.comment-form'), 
		form_text = document.querySelectorAll('.form-text');
		

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
				
				request.open('POST', 'home/save', true);
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
							+ '&image_id=' + e.target.elements[1].value
							+ '&user_id=' + e.target.elements[2].value;

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


	if (alert_box)
	{	
		alert_box.addEventListener("click", function(e){

			e.preventDefault();
			if (e.target.nodeName == 'I')
				e.target.parentNode.remove();
		});
	}

	

}
