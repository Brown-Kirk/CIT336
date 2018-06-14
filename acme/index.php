<?php
    /*
     * Home Controller
     */

    // Create or access a Session
    session_start();
    // Get the various function libraries
    require_once './library/connections.php';
    require_once './model/acme-model.php';
    require_once './library/functions.php';
    // Get the array of categories
    $categories = getCategories();
    // Build a navigation bar using the $categories array
    $navList = buildNav();
    // Removed action value retrieval and switch because it was unused
    // Include the home view
    include 'view/home.php';
?>