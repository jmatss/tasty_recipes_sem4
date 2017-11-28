<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Controller\Controller;
use TastyRecipes\Util\Constants;

class DefaultRequestHandler extends AbstractRequestHandler {
    
    protected function doExecute() {
        $this->session->restart();
        $this->session->set(Constants::CONTR_NAME, new Controller());
        
        \Header('Location: /TastyRecipes/View/FirstPage');
    }

}

