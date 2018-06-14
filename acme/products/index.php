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
    require_once '../model/uploads-model.php';
    require_once '../model/reviews-model.php';

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
            $products = getProductBasics();
            if(count($products) > 0){
                $prodList = '<table>';
                $prodList .= '<thead>';
                $prodList .= '<tr><th>Product Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
                $prodList .= '</thead>';
                $prodList .= '<tbody>';
                foreach ($products as $product) {
                    $prodList .= "<tr><td>$product[invName]</td>";
                    $prodList .= "<td><a href='/acme/products?action=mod-prod&id=$product[invId]' title='Click to modify'>Modify</a></td>";
                    $prodList .= "<td><a href='/acme/products?action=del-prod&id=$product[invId]' title='Click to delete'>Delete</a></td></tr>";
                }
                $prodList .= '</tbody></table>';
            } else {
                $message = '<p class="notify">Sorry, no products were returned.</p>';
            }
            include '../view/prod-mgmt.php';
            break;
        case 'mod-prod':
            $invId = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
            $prodInfo = getProductInfo($invId);
            if(count($prodInfo) <1) {
                $message = 'Sorry, no product information could be found';
            }
            include '../view/prod-update.php';
            exit;
        case 'updateProd':
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

            if (empty($catType) || empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($invVendor) || empty($invStyle)) {
                $message = '<p>Please complete all information for the updated item! Double check the category of the item.</p>';
                include '../view/new-prod.php';
                exit;
            }  $updateResult = updateProduct($catType, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle, $invId);
            if ($updateResult) {
                if ($updateResult) {
                    $message = "<p class='notify'>Congratulations, $invName was successfully updated.</p>";
                    $_SESSION['message'] = $message;
                    header('location: /acme/products/');
                    exit;
                }
            } else {
                $message = "<p>Error. The product was not updated.</p>";
                include '../view/new-prod.php';
                exit;
            }
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
            $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $invStock = filter_input(INPUT_POST, 'invStock', FILTER_VALIDATE_INT);
            $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
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
        case 'del-prod':
            $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $prodInfo = getProductInfo($invId);
            if (count($prodInfo) < 1) {
             $message = 'Sorry, no product information could be found.';
            }
            include '../view/prod-delete.php';
            exit;
        case 'deleteProd':
            $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
            $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
            $deleteResult = deleteProduct($invId);
            if ($deleteResult) {
                $message = "<p class='notice'>Congratulations, $invName was successfully deleted.</p>";
                $_SESSION['message'] = $message;
                header('location: /acme/products/');
                exit;
            } else {
                $message = "<p class='notice'>Error: $invName was not deleted.</p>";
                $_SESSION['message'] = $message;
                header('location: /acme/products/');
                exit;
            }
        case 'category':
            $category = filter_input(INPUT_GET, 'type',FILTER_SANITIZE_STRING);
            $products = getProductsByCategory($category);
            if(!count($products)){
                $message= "<p class='notice'>Sorry, no $category products couild be found.</p>";
            } else {
                $prodDisplay = buildProductsDisplay($products);
            }
            include '../view/category.php';
            exit;
        case 'prod-detail':
            $productId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
            $product = getProductDetails($productId);
            $prodThumbnails = getThumbnails($productId);
            if(!count($product)){
                $message = "<p class='notice'>Sorry, no $prodId could be found.</p>";
            } else {
                $prodDetail = buildProductsDetail($product);
                $thumbnails =buildProdThumbnails($prodThumbnails);
            }
            include '../view/prod-detail.php';
            break;            
            exit;
        default:
            header('location:/acme/');
            break;
   }
?>