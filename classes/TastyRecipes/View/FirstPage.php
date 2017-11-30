<?php
namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;
use TastyRecipes\Controller\Controller;

class FirstPage extends AbstractRequestHandler {
    
    protected function doExecute(): string {
        try {
            $contr = $this->session->get(Constants::CONTR_NAME);
        } catch(\LogicException $e) {
            $this->session->restart();
            $contr = new Controller();
            $this->session->set(Constants::CONTR_NAME, $contr);
        }
        
        if($contr->checkIfLoggedIn()) {
            $this->addVariable(Constants::USERNAME, $contr->getLoggedInUsername());
        }
        return 'index';
    }
}
