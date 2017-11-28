<?php

namespace TastyRecipes\Model;

class Comment {
    private $recipe;
    private $username;
    private $comment;
    private $timestamp;
    
    public function __construct($recipe, $username, $comment, $timestamp) {
        $this->recipe = $recipe;
        $this->username = $username;
        $this->comment = $comment;
        $this->timestamp = $timestamp;
    }
    
    public function getRecipe() {
        return $this->recipe;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getComment() {
        return $this->comment;
    }
    public function getTimestamp() {
        return $this->timestamp;
    }
}

