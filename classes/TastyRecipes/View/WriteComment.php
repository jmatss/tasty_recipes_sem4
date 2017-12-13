<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;
use TastyRecipes\Controller\Controller;

class WriteComment extends AbstractRequestHandler {
    private $recipeNumber;
    private $comment;
    
    public function setRecipeNumber($recipeNumber) {
        $this->recipeNumber = $recipeNumber;
    }
    public function setComment($comment) {
        $this->comment = $comment;
    }

    protected function doExecute(): string {
        try {
            $contr = $this->session->get(Constants::CONTR_NAME);
        } catch(\LogicException $e) {
            $this->session->restart();
            $contr = new Controller();
            $this->session->set(Constants::CONTR_NAME, $contr);
        }
        
        if($contr->checkIfLoggedIn()) {
            $result = $contr->writeComment($this->recipeNumber, $contr->getLoggedInUsername(), $this->comment);
            $this->addVariable('result', $result);
        } else {
            $this->addVariable('result', false);
        }
        return 'jsonResult';
    }
}
