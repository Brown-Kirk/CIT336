<?php
    /*
     * Products Controller
     */

    // Create or access a Session
    session_start();
    
    // Get the database connection file
    require_once '../library/connections.php';
    // Get the acme model for use as needed
    require_once '../model/acme-model.php';
    require_once '../model/products-model.php';
    // Get the functions library
    require_once '../library/functions.php';

    //$navList = buildNav();
    //$categories = getCategories();
    //$catList = buildCategoryList();
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
        if($action == NULL ) {
            $action = 'prod-mgmt';
        }
    }
    
    $level = $_SESSION['clientData']['clientLevel'];
        if($_SESSION['loggedin']){    
        if ($level > 1){
            // continue as normal
        } else {
            $action = 'denied';
        }
    } else {
        $action = 'denied';
    }

    switch ($action){
        case 'denied':
            header('location:/acme/index.php');
            break;
        case 'new-cat':
            include '../view/new-cat.php';
            break;
        case 'new-prod':
            $message = '';
            include '../view/new-prod.php';
            break;
        case 'prod-mgmt':
            include '../view/prod-mgmt.php';
            break;
        case 'add-cat':
            $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);
            if (empty($categoryName)) {
                $message = '<p>Please enter a category name.</p>';
                include '../view/new-cat.php';
                exit;
            }
            $newcat = newCategory($categoryName);
            if ($newcat === 1) {
                $message = "<p>Successfully added $categoryName as a new category.</p>";
                include '../view/new-cat.php';
                exit;
            } else {
                $message = "<p>Failed to add $categoryName. Please try again.</p>";
                include '../view/new-cat.php';
                exit;
            }            
        case 'add-prod':
            $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
            $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
            $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
            $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
            $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_FLAG_ALLOW_FRACTION);
            $invStock = filter_input(INPUT_POST, 'invStock', FILTER_VALIDATE_INT);
            $invSize = filter_input(INPUT_POST, 'invSize', FILTER_FLAG_ALLOW_FRACTION);
            $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_FLAG_ALLOW_FRACTION);
            $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
            $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
            $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
            $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
            if (empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($categoryId) || empty($invVendor) || empty($invStyle)) {
                if (empty($categoryId)) {
                    $message = "<p>Yup - you're not processing the categories right</p>";
                } else {
                    $message = '<p>All fields are required. Please fill in any missing fields.</p>';
                    include '../view/new-prod.php';
                    exit;
                }
            }
            $newProduct = newProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle);
            if ($newProduct === 1) {
                $message = "<p>The product $invName has been added to the inventory.</p>";
                include '../view/new-prod.php';
                exit;
            } else {
                $message = "<p>Failed to add $invName. Please try again.</p>";
                include '../view/new-prod.php';
                exit;
            }
        default:
            $message = "Nope, nope, nope. You're not faking it by manually adding an action!";
            header('location:/acme/index.php');
            break;
   }
?>