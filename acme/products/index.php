<?php
    /*
     * Products Controller
     */
    // Get the database connection file
    require_once '../library/connections.php';
    // Get the acme model for use as needed
    require_once '../model/acme-model.php';
    // Get the product model for use as needed
    require_once '../model/products-model.php';

    $navList = buildNav();
    $categories = getCategories();
    $catList = buildCategoryList();
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
        if($action == NULL ) {
            $action= 'prod-mgmt';
        }
    }
    
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
        if ($action == NULL){
            $action= 'product-management';
     }
    }

    switch ($action){
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
            $categoryName = filter_input(INPUT_POST, 'categoryName');
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
            $invName = filter_input(INPUT_POST, 'invName');
            $invDescription = filter_input(INPUT_POST, 'invDescription');
            $invImage = filter_input(INPUT_POST, 'invImage');
            $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
            $invPrice = filter_input(INPUT_POST, 'invPrice');
            $invStock = filter_input(INPUT_POST, 'invStock');
            $invSize = filter_input(INPUT_POST, 'invSize');
            $invWeight = filter_input(INPUT_POST, 'invWeight');
            $invLocation = filter_input(INPUT_POST, 'invLocation');
            $categoryId = filter_input(INPUT_POST, 'categoryId');
            $invVendor = filter_input(INPUT_POST, 'invVendor');
            $invStyle = filter_input(INPUT_POST, 'invStyle');
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
            include '../view/prod-mgmt.php';
   }
?>