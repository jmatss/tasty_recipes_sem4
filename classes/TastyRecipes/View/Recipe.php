<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;

class Recipe extends AbstractRequestHandler{
    private $recipeNumber;
    private $error;
    
    public function setRecipe($recipe) {
        $this->recipeNumber = $recipe;
    }
    
    public function setError($error) {
        $this->error = $error;
    }
    
    protected function doExecute(): string {
        $contr = $this->session->get(Constants::CONTR_NAME);
        $recipes = $contr->getXmlRecipes();
        $comments = $contr->getComments($this->recipeNumber);
        
        $this->addVariable('recipes', $recipes);
        $this->addVariable('comments', $comments);
        $this->addVariable('recipeNumber', $this->recipeNumber);
        
        if($this->error) {
            $this->addVariable(Constants::ERROR, true);
        }
        if($contr->checkIfLoggedIn()) {
            $this->addVariable(Constants::USERNAME, $contr->getLoggedInUsername());
        }
        return 'recipe';
    }
}
