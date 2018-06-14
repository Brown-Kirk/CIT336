<?php
    /*
     * Products Controller
     */

    // Create or access a Session
    session_start();
    // Get the various function libraries
    require_once '../library/connections.php';
    require_once '../model/acme-model.php';
    require_once '../model/products-model.php';
    require_once '../library/functions.php';
    require_once '../model/uploads-model.php';
    require_once '../model/reviews-model.php';
    // Check to see if the "action" value was posted
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        // If no action value was posted, attempt to get it
        $action = filter_input(INPUT_GET, 'action');
        if($action == NULL ) {
            // If no action value still, set to prod-mgmt as default
            $action = 'prod-mgmt';
        }
    }
    // Get user's clientLevel for elevated access
    if(isset($_SESSION['clientData'])) {
        $level = $_SESSION['clientData']['clientLevel'];
    } else {
        $level = 0;
    }
    // Ensure user is logged in
    if(isset($_SESSION['loggedin'])) {
        if($_SESSION['loggedin']){    
            if ($level > 1){
                // if level is greater than 1, allow access to all views
                $access = 'allowed';
            } else {
                // If level is 1 or less, deny access to certain views
                $access = 'denied';
            }
        } else {
            // If user is not logged in, deny access to certain views
            $access = 'denied';
        }
    }
    // Select course of action based on $action variable      
    switch ($action){
        case 'denied':
            // If action is "denied", reroute to home page
            header('location:/acme/index.php');
            break;
        case 'new-cat':
            // If action is "new-cat", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed, include new category view
                include '../view/new-cat.php';
                exit;
            }
        case 'new-prod':
            // If action is "new-prod", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed, include new product view
                include '../view/new-prod.php';
                exit;
            }
        case 'prod-mgmt':
            // If action is "prod-mgmt", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed, then retrieve basic product information
                $products = getProductBasics();
                // If products info is returned, start building the table
                if(count($products) > 0){
                    // Create table
                    $prodList = '<table>';
                    // Create table header
                    $prodList .= '<thead>';
                    // Add table header values
                    $prodList .= '<tr><th>Product Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
                    // Close table header
                    $prodList .= '</thead>';
                    // Create table body
                    $prodList .= '<tbody>';
                    // For each product in the products array
                    foreach ($products as $product) {
                        // List the product name
                        $prodList .= "<tr><td>$product[invName]</td>";
                        // Create a modify link
                        $prodList .= "<td><a href='/acme/products?action=mod-prod&id=$product[invId]' title='Click to modify'>Modify</a></td>";
                        // Create a delete link
                        $prodList .= "<td><a href='/acme/products?action=del-prod&id=$product[invId]' title='Click to delete'>Delete</a></td></tr>";
                    }
                    // Close the table
                    $prodList .= '</tbody></table>';
                } else {
                    // If no products, then state this
                    $message = '<p class="notify">Sorry, no products were returned.</p>';
                }
                // Include the product management view
                include '../view/prod-mgmt.php';
                break;
            }
        case 'mod-prod':
            // If action is "mod-prod", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed,  set the invId from prior input
                $invId = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
                // Retrieve product info using the getProductInfo function
                $prodInfo = getProductInfo($invId);
                // If no products are returned
                if(count($prodInfo) <1) {
                    // Set the error message accordingly
                    $message = 'Sorry, no product information could be found';
                }
                // Load the Product update view
                include '../view/prod-update.php';
                exit;
            }
        case 'updateProd':
            // If action is "updateProd", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed, retrieve the values entered in the prior form
                $catType = filter_input(INPUT_POST, 'catType', FILTER_SANITIZE_NUMBER_INT);
                $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
                $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
                $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
                $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
                $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
                $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_INT);
                $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_INT);
                $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
                $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
                $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
                $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
                // Check to ensure all fields were completed
                if (empty($catType) || empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($invVendor) || empty($invStyle)) {
                    // If any fields were not completed, set error message accordingly
                    $message = '<p>Please complete all information for the updated item! Double check the category of the item.</p>';
                    // Include the new product view
                    include '../view/new-prod.php';
                    exit;
                }
                // If no fields were empty, use those values to update the database
                $updateResult = updateProduct($catType, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle, $invId);
                if ($updateResult) {
                    // If at least one row was updated, set success message
                    $message = "<p class='notify'>Congratulations, $invName was successfully updated.</p>";
                    // Set success message as a session variable
                    $_SESSION['message'] = $message;
                    // Reroute to the main products page
                    header('location: /acme/products/');
                    exit;
                } else {
                    // If no rows were updated, set the error message accordingly
                    $message = "<p>Error. The product was not updated.</p>";
                    // Return them to the new product view
                    include '../view/new-prod.php';
                    exit;
                }
            }
        case 'add-cat':
            // If action is "add-cat", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed, get category name from previous form
                $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);
                // Check if category name is present
                if (empty($categoryName)) {
                    // If category name is not present, set error message accordingly
                    $message = '<p>Please enter a category name.</p>';
                    // Return them to the new category page
                    include '../view/new-cat.php';
                    exit;
                }
                // If category name is present, create new category in database using newCategory function
                $newcat = newCategory($categoryName);
                // If one row was returned, then
                if ($newcat === 1) {
                    // Set success message
                    $message = "<p>Successfully added $categoryName as a new category.</p>";
                    // Return user to new category page
                    include '../view/new-cat.php';
                    exit;
                } else {
                    // If no row returned, set error message accordingly
                    $message = "<p>Failed to add $categoryName. Please try again.</p>";
                    // Return user to new category page
                    include '../view/new-cat.php';
                    exit;
                }
            }
        case 'add-prod':
            // If action is "add-prod", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed, get values from previous form
                $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
                $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
                $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
                $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
                $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $invStock = filter_input(INPUT_POST, 'invStock', FILTER_VALIDATE_INT);
                $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
                $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
                $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
                $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
                // Check to see if any fields were empty
                if (empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($categoryId) || empty($invVendor) || empty($invStyle)) {
                    // If any field was empty, then 
                    if (empty($categoryId)) {
                        // If it is the categoryId that's empty, then it's a programming thing. They can't not select one. Set the idiot message accordingly
                        $message = "<p>Yup - you're not processing the categories right</p>";
                        // Should never reach this point, so... Why did I check? But anyway, we do nothing.
                    } else {
                        // If it is any other field that is empty, set error message accordingly
                        $message = '<p>All fields are required. Please fill in any missing fields.</p>';
                        // Return user to the new product page
                        include '../view/new-prod.php';
                        exit;
                    }
                }
                // If no fields are empty, add the new product to the database using the newProduct function
                $newProduct = newProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle);
                // Check to see if a single row was returned as we only add one item at a time
                if ($newProduct === 1) {
                    // If one row was updated, set success message
                    $message = "<p>The product $invName has been added to the inventory.</p>";
                    // Return to the new product page
                    include '../view/new-prod.php';
                    exit;
                } else {
                    // If no row was returned, set error message accordingly
                    $message = "<p>Failed to add $invName. Please try again.</p>";
                    // Return user to the new product page
                    include '../view/new-prod.php';
                    exit;
                }
            }
        case 'del-prod':
            // If action is "del-prod", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed, get invId from prior form
                $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                // Get product info from database
                $prodInfo = getProductInfo($invId);
                // Check if product exists
                if (count($prodInfo) < 1) {
                    // If product does not exist, set error message accordingly
                    $message = 'Sorry, no product information could be found.';
                }
                // Reroute them to product delete view
                include '../view/prod-delete.php';
                exit;
            }
        case 'deleteProd':
            // If action is "deleteProd", check access value
            if ($access == 'denied') {
                // If access is denied, reroute user to home page
                header('location:/acme/index.php');
                exit;
            } else {
                // If action is allowed, get product info from prior form
                $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
                $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
                // Delete product form the database using the deleteProduct function
                $deleteResult = deleteProduct($invId);
                // Check for a row count from result
                if ($deleteResult) {
                    // If row result is 1 or greater, set success message
                    $message = "<p class='notice'>Congratulations, $invName was successfully deleted.</p>";
                    // Set message as a session message
                    $_SESSION['message'] = $message;
                    // Reroute to main products page
                    header('location: /acme/products/');
                    exit;
                } else {
                    // If row result is 0, set error message accordingly
                    $message = "<p class='notice'>Error: $invName was not deleted.</p>";
                    // Set error message as a session message
                    $_SESSION['message'] = $message;
                    // Reroute user to main products page
                    header('location: /acme/products/');
                    exit;
                }
            }
        case 'category':
            // If action is "category", get category from prior form
            $category = filter_input(INPUT_GET, 'type',FILTER_SANITIZE_STRING);
            // Get product list for that category from the database using getProductsByCategory
            $products = getProductsByCategory($category);
            // If no products are retrieved
            if(!count($products)){
                // Set error message accordingly
                $message= "<p class='notice'>Sorry, no $category products couild be found.</p>";
            } else {
                // If products are retrieved, use this info to build the display using buildProductsDisplay function
                $prodDisplay = buildProductsDisplay($products);
            }
            // Include the category view
            include '../view/category.php';
            exit;
        case 'prod-detail':
            // If action is "prod-detail", then get id from previous form
            $productId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
            // Use getProductDetails fuction to retrieve product info
            $product = getProductDetails($productId);
            // Use getThumbnails to get all thumbnails associated with selected product
            $prodThumbnails = getThumbnails($productId);
            // Check if at least one product is returned
            if(!count($product)){
                // If no product is returned, set error message
                $message = "<p class='notice'>Sorry, no $prodId could be found.</p>";
            } else {
                // If a product is returned, us the buildProductsDetail function to build detail
                $prodDetail = buildProductsDetail($product);
                // Use buildProdThumbnails function to build list of all thumbnails
                $thumbnails = buildProdThumbnails($prodThumbnails);
            }
            // Include the product detail view
            include '../view/prod-detail.php';
            exit;
        default:
            // If no action is passed, reroute them to the main home page
            header('location:/acme/');
            break;
   }
?>