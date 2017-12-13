<h1>Comments</h1>
<ul class="comments">
    <script>readComments(<?php echo $recipeNumber; ?>, "<?php echo $username; ?>");</script>
</ul><br/>
<div id="line"></div>
<?php
	if(!empty($username)) {
		echo '
			<form onsubmit="writeComment();return false" method="post">
				<br/><label for="name">Username:</label> <b>' . $username . '</b><br/>
				<input type="hidden" name="recipeNumber" value="' . $recipeNumber . '">
                                <input type="hidden" name="username" value="' . $username . '">
				<label for="comment">Write your comment here:</label><br/>
				<textarea id="comment" name="comment"></textarea><br/>
				<input type="submit" value="Post comment">
				<input type="reset" value="Reset">
			</form>
                        <p name="commentMessage"></p>
                ';
	} else {
		echo '<br/><p>You must log in to write comments!</p>';
	}
?>