window.onload = function() {

	var alert_box = document.querySelector('.alert');


	alert_box.addEventListener("click", function(e){

		e.preventDefault();
		if (e.target.nodeName == 'I')
			e.target.parentNode.remove();
	});

}
