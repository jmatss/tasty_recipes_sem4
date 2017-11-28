<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;

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
        $contr = $this->session->get(Constants::CONTR_NAME);
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
