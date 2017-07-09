<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../App/Views/Partials/header.php'; ?>
    <title>Home</title>
</head
<body>
	<?php require '../App/Views/Partials/nav.php'; ?>
	<h1>Titre 1</h1>
	<p>Hello from the Home view!</p> 
	<?php echo "Welcome back $name, your favorite color is $colours[1]"; ?>
	<?php require '../App/Views/Partials/footer.php'; ?>
</body>
</html>
