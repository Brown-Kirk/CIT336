<?php
    /*
     * Acme Controller
     */

    // Create or access a Session
    session_start();
    
    // Get the database connection file
    require_once './library/connections.php';
    // Get the acme model for use as needed
    require_once './model/acme-model.php';
    // Get the functions library
    require_once './library/functions.php';
    
    $categories = getCategories();
    $navList = buildNav();
    $action = filter_input(INPUT_POST, 'action');
    
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }
    switch ($action){
        case 'something':
        break;
        default:
        include 'view/home.php';
   }
?>