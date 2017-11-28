<?php

namespace TastyRecipes\Integration;

class TastyRecipesXAO {
    public function getXmlRecipes() {
        return \simplexml_load_file(\TastyRecipes\Util\Constants::getViewXmlDir() . 'recipes.xml');
    }
}
