<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;
use TastyRecipes\Controller\Controller;

class DeleteComment extends AbstractRequestHandler {
    private $timestamp;
    private $username;
    private $recipeNumber;
    
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setReturnRecipeNumber($recipeNumber) {
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
        
        $contr->deleteComment($this->timestamp, $this->username);
        
        \Header('Location: Recipe?recipe=' . $this->recipeNumber);
    }
}