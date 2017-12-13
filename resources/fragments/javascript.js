function readComments(recipeNumber, sessionUsername) {
    $.getJSON("ReadComments", "recipeNumber=" + recipeNumber, 
        function (comments) {
            console.log(comments);//logging
            if (typeof comments !== "undefined") {
                $.each(comments, function(key, comment) {
                    if ( comment.username === sessionUsername) {
                        $(".comments").append('<li>' 
                                +'<p class="comment_name">' + comment.username + '</p> '
                                +'<button name="' + comment.timestamp + '" type="button" onclick="deleteComment(\'' + comment.timestamp + '\')">Delete</button>'
                                +'<p>' + comment.comment + '</p>'
                            +'</li>');
                    } else {
                        $(".comments").append('<li>' 
                                +'<p class="comment_name">' + comment.username + '</p>'
                                +'<p>' + comment.comment + '</p>'
                            +'</li>');
                    }
                });
            } else {
                $(this).append('<p>No comments found!</p>');
            }
        }
    );
}

function deleteComment(timestamp) {
    $.getJSON("DeleteComment", "timestamp=" + timestamp, 
        function (resultTimestamp) {
            if (resultTimestamp) {
                $('[name="' + timestamp + '"]').parent().remove();
            }
        }
    );
}

function writeComment() {
    var recipeNumber = $('[name=recipeNumber]').val();
    var username = $('[name=username]').val();
    var comment = $('[name=comment]').val().replace("\n", "<br/>");
    var urlComment = $('[name=comment]').val().replace("\n", "%0A");
    
    $.getJSON("WriteComment", "recipeNumber=" + recipeNumber + "&comment=" + urlComment, 
        function (resultTimestamp) {
            if (resultTimestamp) {
                $(".comments").append('<li>' 
                    +'<p class="comment_name">' + username + '</p> '
                    +'<button name="' + resultTimestamp + '" type="button" onclick="deleteComment(\'' + resultTimestamp + '\')">Delete</button>'
                    +'<p>' + comment + '</p>'
                +'</li>');
            }
        }
    );
    $('[name=comment]').val('');
    console.log($('[name=comment]').val());
}