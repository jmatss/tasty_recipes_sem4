<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tasty Recipes</title>
        <meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../resources/css/reset.css" />
                <link rel="stylesheet" type="text/css" href="../../resources/css/style.css" />
	</head>
	<body>
		<header>
			<?php include TastyRecipes\Util\Constants::getViewFragmentsDir() . 'header.php' ?> 
		</header>
		<nav>
			<?php include TastyRecipes\Util\Constants::getViewFragmentsDir() . 'nav.php' ?> 
		</nav>
		<div class="main">
			<section class="main_section">
			<h1>Register</h1><br/>
                                <form action="RegisterPost" method="post">
                                        <label for="username" class="label">Username:</label><br/>
                                        <input type="text" name="username" id="username"><br/>
                                        <label for="password" class="label">Password:</label><br/>
                                        <input type="password" name="password" id="password"><br/><br/>
                                        <input type="submit" value="Log in">
                                        <input type="reset" value="Reset">
                                </form>
                        
                                <?php
                                    if ($error) {
                                        echo '<p class="errortext">This username is already taken!</p>';
                                    }
                                ?>
			</section>
			<br/>
		</div>
	</body>
</html>