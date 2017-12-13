<?php

namespace TastyRecipes\Model;

class Comment implements \JsonSerializable {
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

    public function jsonSerialize() {
        $json_obj = new \stdClass();
        $json_obj->recipe = $this->recipe;
        $json_obj->username = $this->username;
        $json_obj->comment = $this->comment;
        $json_obj->timestamp = $this->timestamp;
        
        return $json_obj;
    }
}

