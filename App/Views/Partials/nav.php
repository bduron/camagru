<?php use \App\Auth; ?>

<?php if (Auth::isLoggedIn()): ?>
	<nav>
	     <a href="/">home</a> | 
	     <a href="/montage">+ new picture</a> |
	     <a href="/logout">logout</a>
	</nav>
<?php  else: ?>
	<nav>
	     <a href="/">home</a> | 
	     <a href="/signup/new">sign up</a> |
	     <a href="/login">log in</a>
	</nav>
<?php  endif; ?>
