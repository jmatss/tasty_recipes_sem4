<?php

namespace TastyRecipes\Controller;

use TastyRecipes\Integration\TastyRecipesDAO;
use TastyRecipes\Integration\TastyRecipesXAO;
use TastyRecipes\Model\User;

class Controller {
        private $tastyRecipesDAO;
        private $tastyRecipesXAO;
        private $user;

        function __construct() {
            $this->tastyRecipesDAO = new TastyRecipesDAO();
            $this->tastyRecipesXAO = new TastyRecipesXAO();
        }
        
        public function getXmlRecipes() {
            return $this->tastyRecipesXAO->getXmlRecipes();
        }

        public function loginUser($username, $password) {
            if (!ctype_alnum($username) || !ctype_alnum($password)) {
                return false;
            }
            $result = $this->tastyRecipesDAO->getUser($username, $password);
            if ($result) {
                $this->user = new User($result);
                return true;
            } else {
                return false;
            }
        }
        
        public function checkIfLoggedIn() {
            return !is_null($this->user);
        }
        public function getLoggedInUsername() {
            return $this->user->getUsername();
        }
        public function logoutUser() {
            $this->user = null;
        }

        public function getComments($recipe) {
            return $this->tastyRecipesDAO->getComments($recipe);
        }

        public function writeComment($recipe, $username, $comment) {
            if (empty($username) || empty($comment) || ctype_space($comment)) {
                return false;
            }

            $timestamp = \date('Y-m-d H:i:s');
            if($this->tastyRecipesDAO->writeComment($recipe, $username, \nl2br(\htmlentities($comment)), $timestamp)) {
                return $timestamp;
            } else {
                return false;
            }
        }

        public function deleteComment($timestamp, $username) {
            return $this->tastyRecipesDAO->deleteComment($timestamp, $username);
        }

        public function registerUser($username, $password) {
            if (!ctype_alnum($username) || !ctype_alnum($password)) {
                return false;
            }
            if ($this->tastyRecipesDAO->checkIfUsernameTaken($username)) {
                return false;
            } else {
                if($this->tastyRecipesDAO->registerUser($username, $password)) {
                    return $this->loginUser($username, $password);
                } else {
                    return false;
                }
            }
        }
}
