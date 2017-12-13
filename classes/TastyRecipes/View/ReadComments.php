<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;
use TastyRecipes\Controller\Controller;

class ReadComments extends AbstractRequestHandler  {
    private $recipeNumber;
    private $comments;
    
    public function setRecipeNumber($recipeNumber) {
        $this->recipeNumber = $recipeNumber;
    }

    protected function doExecute(): string {
        
        try {
            $contr = $this->session->get(Constants::CONTR_NAME);
        } catch(\LogicException $e) {
            $this->session->restart();
            $contr = new Controller();
            $this->session->set(Constants::CONTR_NAME, $contr);
        }
        
        if(\is_null($this->recipeNumber)) {
            $this->recipeNumber = -1;
        }
        
        $this->comments = $contr->getComments($this->recipeNumber);
        $this->addVariable('result', $this->comments);
        
        return 'jsonResult';
    }
}
