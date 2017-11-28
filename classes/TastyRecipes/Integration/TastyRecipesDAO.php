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
    private $contest;
    private $string;
    
    private $USER_DB;
    private $PASSWORD_DB;
    
    
    public function __construct() {
        include 'C:\UniServerZ\www\login.php';
        $this->USER_DB = $USER_DB;
        $this->PASSWORD_DB = $PASSWORD_DB;
        \mysqli_report(MYSQLI_REPORT_ERROR | MYSQLII_REPORT_STRICT);
        $this->connection = new \mysqli(Constants::HOST_DB, $USER_DB, $PASSWORD_DB, Constants::DATABASE_DB);
        $this->createContentStmts();
        $this->contest = mysqli_ping($this->connection);
    }
    
    public function getUser($username, $password) {
        $USER_DB = $this->USER_DB;
        $PASSWORD_DB = $this->PASSWORD_DB;
        $this->connection = new \mysqli(Constants::HOST_DB, $USER_DB, $PASSWORD_DB, Constants::DATABASE_DB);
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
        $USER_DB = $this->USER_DB;
        $PASSWORD_DB = $this->PASSWORD_DB;
        $this->connection = new \mysqli(Constants::HOST_DB, $USER_DB, $PASSWORD_DB, Constants::DATABASE_DB);
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
    
    public function writeComment($recipe, $username, $comment) {
        $USER_DB = $this->USER_DB;
        $PASSWORD_DB = $this->PASSWORD_DB;
        $this->connection = new \mysqli(Constants::HOST_DB, $USER_DB, $PASSWORD_DB, Constants::DATABASE_DB);
        $this->insertCommentStmt = $this->connection->prepare("INSERT INTO " . self::COMMENT . " (" . self::COMMENT_RECIPE_COL_NAME . ", " . self::COMMENT_USERNAME_COL_NAME . ", "
                . "" . self::COMMENT_COMMENT_COL_NAME . ", " . self::COMMENT_TIMESTAMP_COL_NAME . ") VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
        
        $this->insertCommentStmt->bind_param('iss', $recipe, $username, $comment);
        return $this->insertCommentStmt->execute();
    }
    
    public function deleteComment($timestamp, $username) {
        $USER_DB = $this->USER_DB;
        $PASSWORD_DB = $this->PASSWORD_DB;
        $this->connection = new \mysqli(Constants::HOST_DB, $USER_DB, $PASSWORD_DB, Constants::DATABASE_DB);
        $this->deleteCommentStmt = $this->connection->prepare("DELETE FROM " . self::COMMENT . " WHERE " . self::COMMENT_TIMESTAMP_COL_NAME . " = ? AND " . self::COMMENT_USERNAME_COL_NAME . " = ?");
        
        $this->deleteCommentStmt->bind_param('ss', $timestamp, $username); 
        return $this->deleteCommentStmt->execute();
    }
    
    public function registerUser($username, $password) {
        $USER_DB = $this->USER_DB;
        $PASSWORD_DB = $this->PASSWORD_DB;
        $this->connection = new \mysqli(Constants::HOST_DB, $USER_DB, $PASSWORD_DB, Constants::DATABASE_DB);
        $this->selectUserStmt = $this->connection->prepare("SELECT " . self::USER_USERNAME_COL_NAME . " FROM " . self::USER . " WHERE " . self::USER_USERNAME_COL_NAME . " = ?");
        $this->insertUserStmt = $this->connection->prepare("INSERT INTO " . self::USER . " (" . self::USER_USERNAME_COL_NAME . ", " . self::USER_PASSWORD_COL_NAME . ") VALUES (?, ?)");
        
        $this->selectUserStmt->bind_param('s', $username);
        $this->selectUserStmt->execute();
        $this->selectUserStmt->bind_result($username_result);
        
        if($this->selectUserStmt->fetch()) {    // username already taken
            return false;
        } else {
            $hashedPassword = \password_hash($password, PASSWORD_DEFAULT);
            $this->insertUserStmt->bind_param('ss', $username, $hashedPassword);
            return $this->insertUserStmt->execute();
        }
    }
    
    public function createContentStmts() {
        $this->selectLoginStmt = $this->connection->prepare("SELECT " . self::USER_USERNAME_COL_NAME . ", " . self::USER_PASSWORD_COL_NAME . " FROM " . self::USER . " WHERE " . self::USER_USERNAME_COL_NAME . " = ?");
        $this->selectCommentsStmt = $this->connection->prepare("SELECT " . self::COMMENT_RECIPE_COL_NAME . ", " . self::COMMENT_USERNAME_COL_NAME . ", " . self::COMMENT_COMMENT_COL_NAME .
                ",  " . self::COMMENT_TIMESTAMP_COL_NAME . " FROM " . self::COMMENT . " WHERE " . self::COMMENT_RECIPE_COL_NAME . " = ?");
        $this->insertCommentStmt = $this->connection->prepare("INSERT INTO " . self::COMMENT . " (" . self::COMMENT_RECIPE_COL_NAME . ", " . self::COMMENT_USERNAME_COL_NAME . ", "
                . "" . self::COMMENT_COMMENT_COL_NAME . ", " . self::COMMENT_TIMESTAMP_COL_NAME . ") VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
        $this->deleteCommentStmt = $this->connection->prepare("DELETE FROM " . self::COMMENT . " WHERE " . self::COMMENT_TIMESTAMP_COL_NAME . " = ? AND " . self::COMMENT_USERNAME_COL_NAME . " = ?");
        $this->selectUserStmt = $this->connection->prepare("SELECT " . self::USER_USERNAME_COL_NAME . " FROM " . self::USER . " WHERE " . self::USER_USERNAME_COL_NAME . " = ?");
        $this->insertUserStmt = $this->connection->prepare("INSERT INTO " . self::USER . " (" . self::USER_USERNAME_COL_NAME . ", " . self::USER_PASSWORD_COL_NAME . ") VALUES (?, ?)");
    }
}
