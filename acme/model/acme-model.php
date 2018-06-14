<?php

/* 
 * Acme Model
 */

/* 
 * buildNav() creates the navigation menu for use in the header of all pages on the site
 */

function buildNav() {
    // Get list of categoreis
    $categories = getCategories();
    // Build a navigation bar using the $categories array
    $navList = '<ul id="dropdown">';
    $navList .= "<li><a href='/acme/' title='View the Acme home page'>Home</a></li>";
    // Add a clickable link and name to the menu for each category
    foreach ($categories as $category) {
        $navList .= "<li><a href='/acme/products/index.php?action=category&type=".urlencode($category['categoryName'])."' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
    }
    // Close out the unordered list
    $navList .= '</ul>';
    $navList .= '<p class="menu">Menu</p>';
    // Return completed value
    return $navList;
}