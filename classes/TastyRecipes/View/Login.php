<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;

class Login extends AbstractRequestHandler {
    protected function doExecute(): string {
        $contr = $this->session->get(Constants::CONTR_NAME);
        
        if($contr->checkIfLoggedIn()) {
            $this->addVariable(Constants::USERNAME, $contr->getLoggedInUsername());
            return 'loggedIn';
        } else {
            return 'loginForm';
        }
    }
}
