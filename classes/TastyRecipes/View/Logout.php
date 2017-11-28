<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;

class Logout extends AbstractRequestHandler {
    protected function doExecute(): string {
        $contr = $this->session->get(Constants::CONTR_NAME);
        $contr->logoutUser();
        $this->session->set(Constants::CONTR_NAME, $contr);
        
        return 'loggedOut';
    }
}
