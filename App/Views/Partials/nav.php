<?php use \App\Auth; ?>

<?php if (Auth::isLoggedIn()): ?>
	<nav class="navbar">
		<div class="menu">
			<a id="logo" href="/">camagru</a>
			<ul class="menu-items">
				<li><a href="/montage">+ new picture</a></li>
				<li><a href="/profile" id="profile"><i class="material-icons">person_outline</i></a></li>
				<li><a href="/logout" id="logout"><i class="material-icons">power_settings_new</i></a></li>
			</ul>
		</div>
	</nav>
<?php  else: ?>
	<nav class="navbar">
		<div class="menu">
			<a id="logo" href="/">camagru</a>
			<ul class="menu-items">
				<li><a href="/signup/new">sign up</a></li>
				<li><a href="/login">log in</a></li>
			</ul>
		</div>
	</nav>
<?php  endif; ?>
<div class="topmargin"></div>
