<h1>Comments</h1>
<ul class="comments">
	<?php
            foreach ($comments as $comment) {
                echo '
                    <li>
                        <p class="comment_name">' . $comment->getUsername() . '</p>
                ';

                if ($comment->getUsername() == $username) {
                    echo '
                        <form action="DeleteComment" method="post" id="deleteform">
                            <input type="hidden" name="timestamp" value="' . $comment->getTimestamp() . '">
                            <input type="hidden" name="returnRecipeNumber" value="' . $comment->getRecipe() . '">
                            <input type="submit" value="Delete">
                        </form>
                    ';
                }

                echo '
                        <p>' . $comment->getComment() . ' </p>
                    </li>
                ';
            }

            if (empty($comments)) {
                echo '<p>No comments found!</p>';
            }
	?>
</ul>
<div id="line"></div>
<?php
	if(!empty($username)) {
		echo '
			<form action="WriteComment" method="post">
				<br/><label for="name">Username:</label> <b>' . $username . '</b><br/>
				<input type="hidden" name="recipeNumber" value="' . $recipeNumber . '">
				<label for="comment">Write your comment here:</label><br/>
				<textarea id="comment" name="comment"></textarea><br/>
				<input type="submit" value="Post comment">
				<input type="reset" value="Reset">
			</form>
                ';
                        if ($error) {
                            echo '<p class="errortext"><br/>Couldn\'t save your comment, try again!</p>';
                        }
	} else {
		echo '<br/><p>You must log in to write comments!</p>';
	}
?>