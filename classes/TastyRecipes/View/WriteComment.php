<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;

class WriteComment extends AbstractRequestHandler {
    private $recipeNumber;
    private $username;
    private $comment;
    
    public function setRecipeNumber($recipeNumber) {
        $this->recipeNumber = $recipeNumber;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setComment($comment) {
        $this->comment = $comment;
    }

    protected function doExecute(): string {
        $contr = $this->session->get(Constants::CONTR_NAME);
        if (!($contr->writeComment($this->recipeNumber, $this->username, $this->comment))) {    // something wrong
            \Header('Location: Recipe?recipe=' . $this->recipeNumber . '&error=true');
        } else {
            \Header('Location: Recipe?recipe=' . $this->recipeNumber);
        }
    }
}
