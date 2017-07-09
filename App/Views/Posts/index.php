<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"> 
	<title>Home</title>	
</head>
<body>
	<h1>Welcome</h1>
	<p>Hello from the Posts view!</p> 

	<?php foreach ($posts as $post):  ?>			
  		<?php echo '<h2>' . h($post['title'])  . '</h2>'  ?>		
  		<?php echo '<p>' . h($post['content'])  . '</p>'  ?>		
  	<?php endforeach; ?>		

</body>
</html>
