<div id="nav_div">
	<ul>
		<li>
			<a href="FirstPage">
				Recipes
			</a>
		</li><li>
			<a href="Calendar">
				Calendar
			</a>
		</li>
	</ul>
	<?php
		if (empty($username)) {
			echo '
				<div id="login">
					<a href="Login">Log in</a> | 
					<a href="Register">Register</a>
				</div>
			';
		} else {
			echo '
				<div id="login">
					Logged in as: <b>' . $username . '</b> ,<a href="Logout">Log out</a>
				</div>
			';
		}
	?>
</div>