<?php

namespace TastyRecipes\View;

use Id1354fw\View\AbstractRequestHandler;
use TastyRecipes\Util\Constants;
use TastyRecipes\Controller\Controller;

class DeleteComment extends AbstractRequestHandler {
    private $timestamp;
    
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
    
    protected function doExecute(): string {
        try {
            $contr = $this->session->get(Constants::CONTR_NAME);
        } catch(\LogicException $e) {
            $this->session->restart();
            $contr = new Controller();
            $this->session->set(Constants::CONTR_NAME, $contr);
        }

        if($contr->checkIfLoggedIn() && $contr->deleteComment($this->timestamp, $contr->getLoggedInUsername()))
        {
            $this->addVariable('result', $this->timestamp);
        } else {
            $this->addVariable('result', false);
        }
        return 'jsonResult';
    }
}