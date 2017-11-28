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
			<h1>Log in</h1><br/>
                                <?php echo '<p>You are logged in as <b>'. $username . '</b>!</p>'; ?>
			</section>
			<br/>
		</div>
	</body>
</html>