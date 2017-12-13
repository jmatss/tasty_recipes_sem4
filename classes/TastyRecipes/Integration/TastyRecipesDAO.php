<?php

namespace TastyRecipes\Integration;

use TastyRecipes\Util\Constants;

class TastyRecipesDAO {
    const USER = 'user';
    const USER_USERNAME_COL_NAME = 'username';
    const USER_PASSWORD_COL_NAME = 'password';
    
    const COMMENT = 'comment';
    const COMMENT_RECIPE_COL_NAME = 'recipe';
    const COMMENT_USERNAME_COL_NAME = 'username';
    const COMMENT_COMMENT_COL_NAME = 'comment';
    const COMMENT_TIMESTAMP_COL_NAME = 'timestamp';
    
    private $selectLoginStmt;
    private $selectCommentsStmt;
    private $insertCommentStmt;
    private $deleteCommentStmt;
    private $selectUserStmt;
    private $insertUserStmt;
    private $connection;
    
    private $USER_DB;
    private $PASSWORD_DB;
    
    
    public function __construct() {
        include 'C:\UniServerZ\www\login.php';
        $this->USER_DB = $USER_DB;
        $this->PASSWORD_DB = $PASSWORD_DB;
    }
    
    public function connect() {
        \mysqli_report(MYSQLI_REPORT_ERROR | MYSQLII_REPORT_STRICT);
        $this->connection = new \mysqli(Constants::HOST_DB, $this->USER_DB, $this->PASSWORD_DB, Constants::DATABASE_DB);
    }
    
    public function getUser($username, $password) {
        $this->connect();
        $this->selectLoginStmt = $this->connection->prepare("SELECT " . self::USER_USERNAME_COL_NAME . ", " . self::USER_PASSWORD_COL_NAME . " FROM " . self::USER . " WHERE " . self::USER_USERNAME_COL_NAME . " = ?");
        
        $this->selectLoginStmt->bind_param('s', $username);
        $this->selectLoginStmt->execute();
        $this->selectLoginStmt->bind_result($result_username, $result_password);
        
        if($this->selectLoginStmt->fetch() && \password_verify($password, $result_password)) {
            return $result_username;
        } else {
            return false;
        }
    }
    
    public function getComments($recipe) {
        $this->connect();
        $this->selectCommentsStmt = $this->connection->prepare("SELECT " . self::COMMENT_RECIPE_COL_NAME . ", " . self::COMMENT_USERNAME_COL_NAME . ", " . self::COMMENT_COMMENT_COL_NAME . 
                ",  " . self::COMMENT_TIMESTAMP_COL_NAME . " FROM " . self::COMMENT . " WHERE " . self::COMMENT_RECIPE_COL_NAME . " = ?");
        
        $comments = array();
        $this->selectCommentsStmt->bind_param('i', $recipe);
        $this->selectCommentsStmt->execute();
        $this->selectCommentsStmt->bind_result($recipe, $username, $comment, $timestamp);
        while($this->selectCommentsStmt->fetch()) {
            $comments[] = new \TastyRecipes\Model\Comment($recipe, $username, $comment, $timestamp);
        }

        if (empty($comments)) {
            return false;
        } else {
            return $comments;
        }
    }
    
    public function writeComment($recipe, $username, $comment, $timestamp) {
        $this->connect();
        $this->insertCommentStmt = $this->connection->prepare("INSERT INTO " . self::COMMENT . " (" . self::COMMENT_RECIPE_COL_NAME . ", " . self::COMMENT_USERNAME_COL_NAME . ", "
                . "" . self::COMMENT_COMMENT_COL_NAME . ", " . self::COMMENT_TIMESTAMP_COL_NAME . ") VALUES (?, ?, ?, ?)");
        
        $this->insertCommentStmt->bind_param('isss', $recipe, $username, $comment, $timestamp);
        return $this->insertCommentStmt->execute();
    }
    
    public function deleteComment($timestamp, $username) {
        $this->connect();
        $this->deleteCommentStmt = $this->connection->prepare("DELETE FROM " . self::COMMENT . " WHERE " . self::COMMENT_TIMESTAMP_COL_NAME . " = ? AND " . self::COMMENT_USERNAME_COL_NAME . " = ?");
        
        $this->deleteCommentStmt->bind_param('ss', $timestamp, $username); 
        return $this->deleteCommentStmt->execute();
    }
    
    public function checkIfUsernameTaken($username) {
        $this->connect();
        $this->selectUserStmt = $this->connection->prepare("SELECT " . self::USER_USERNAME_COL_NAME . " FROM " . self::USER . " WHERE " . self::USER_USERNAME_COL_NAME . " = ?");
        
        $this->selectUserStmt->bind_param('s', $username);
        $this->selectUserStmt->execute();
        $this->selectUserStmt->bind_result($username_result);
        return $this->selectUserStmt->fetch();
    }
    
    public function registerUser($username, $password) {
        $this->connect();
        $this->insertUserStmt = $this->connection->prepare("INSERT INTO " . self::USER . " (" . self::USER_USERNAME_COL_NAME . ", " . self::USER_PASSWORD_COL_NAME . ") VALUES (?, ?)");
        
        $hashedPassword = \password_hash($password, PASSWORD_DEFAULT);
        $this->insertUserStmt->bind_param('ss', $username, $hashedPassword);
        return $this->insertUserStmt->execute();
    }
}
