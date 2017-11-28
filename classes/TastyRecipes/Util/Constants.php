<?php

namespace TastyRecipes\Util;

use Id1354fw\Util\Classes;

class Constants {
    const FRAGMENT_DIR  = 'resources/fragments';
    const CONTR_NAME = 'contr';
    const USERNAME = 'username';
    const ERROR = 'error';
    
    const HOST_DB = 'localhost';
    const DATABASE_DB = 'tasty_recipes';
    
    public static function getViewFragmentsDir() {
        return $_SERVER['DOCUMENT_ROOT'] . Classes::getContextPath() . '/resources/fragments/';
    }
    
     public static function getViewXmlDir() {
        return $_SERVER['DOCUMENT_ROOT'] . Classes::getContextPath() . '/resources/XML/';
    }
}