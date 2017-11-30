<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;

class DefaultRequestHandler extends AbstractRequestHandler {
    
    protected function doExecute() {
        \Header('Location: /TastyRecipes/View/FirstPage');
    }

}

