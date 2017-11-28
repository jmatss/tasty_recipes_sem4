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
				<?php
                                        if(!isset($recipeNumber)) {
						echo 'Couldn\'t find the specified recipe, try again!';
						exit;
					}
					if ($recipes === false) {
						echo 'Failed to load recipes, try again!';
						exit;
					}
                                        if (!is_numeric($recipeNumber) || ((int)$recipeNumber) < 0) {
                                                echo 'Couldn\'t find the specified recipe, try again!';
						exit;
                                        }
                                        $recipeNumber = (int) $recipeNumber;
					if (empty($recipes->recipe[$recipeNumber])) {
						echo 'Couldn\'t find the specified recipe, try again!';
						exit;
					}
				?>
				<div class="recipe_header"> 
					<h1><?php echo $recipes->recipe[$recipeNumber]->title; ?></h1>
					<div class="recipe_header_info">
						<ul id="bold">
							<li>
								Prep time
							</li>
							<li>
								Cook time
							</li>
							<li>
								Servings
							</li>
						</ul>
						<ul>
							<li>
								<?php echo $recipes->recipe[$recipeNumber]->preptime ?>
							</li>
							<li>
								<?php echo $recipes->recipe[$recipeNumber]->cooktime ?>
							</li>
							<li>
								<?php echo $recipes->recipe[$recipeNumber]->servings ?>
							</li>
						</ul>
					</div>
				</div>
				<div class="image_div_recipe">
				<?php echo '<img src="../../resources' . $recipes->recipe[$recipeNumber]->imagepath . '" alt="Picture of '. $recipes->recipe[$recipeNumber]->title . '"/>' ?>
				</div>
				<?php
					foreach($recipes->recipe[$recipeNumber]->description->li as $description) {
						echo '<p>' . $description . '</p>';
					}
				?>
			</section>
			<section class="main_section">
				<h1>Ingredients</h1>
				<ul class="ingredients">
					<?php
						foreach($recipes->recipe[$recipeNumber]->ingredient->li as $ingredient) {
							echo '<li>' . $ingredient . '</li>';
						}
					?>
				</ul>
			</section>
			<section class="main_section">
				<h1>Instructions</h1>
				<ol class="instructions">
					<?php
						foreach($recipes->recipe[$recipeNumber]->recipetext->li as $recipetext) {
							echo '<li>' . $recipetext . '</li>';
						}
					?>
				</ol>
			</section>
			<section class="main_section">
				<?php include TastyRecipes\Util\Constants::getViewFragmentsDir() . 'comments.php' ?> 
			</section>
			<br/>
		</div>
	</body>
</html>