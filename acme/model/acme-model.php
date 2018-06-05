<?php

/* 
 * Acme Model
 */

function buildNav() {
    $categories = getCategories();
    // Build a navigation bar using the $categories array
    $navList = '<ul id="dropdown">';
    $navList .= "<li><a href='/acme/' title='View the Acme home page'>Home</a></li>";
    foreach ($categories as $category) {
        $navList .= "<li><a href='/acme/index.php?action=".urlencode($category['categoryName'])."' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
    }
    $navList .= '</ul>';
    $navList .= '<p class="menu">Menu</p>';
    return $navList;
}