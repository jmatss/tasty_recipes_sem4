<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;
use TastyRecipes\Controller\Controller;

class LoginPost extends AbstractRequestHandler {
    private $username;
    private $password;
    
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    
    protected function doExecute(): string {
        try {
            $contr = $this->session->get(Constants::CONTR_NAME);
        } catch(\LogicException $e) {
            $this->session->restart();
            $contr = new Controller();
            $this->session->set(Constants::CONTR_NAME, $contr);
        }
        
        $result = $contr->loginUser($this->username, $this->password);
        if($result) {
            $username = $contr->getLoggedInUsername();
            $this->addVariable(Constants::USERNAME, $contr->getLoggedInUsername());
            $this->session->set(Constants::CONTR_NAME, $contr);
            
            return 'loggedIn';
        } else {
            $this->addVariable(Constants::ERROR, true);
            
            return 'loginForm';
        }
    }
}
