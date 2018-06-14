<?php

/* 
 * Products model
 */

/*
 * buildCategoryList() will build a select box with a list of valid categories to be used in forms
 */

function buildCategoryList() {
    // Get the list of categories from the getCategories function
    $categories = getCategories();
    // Create the select box
    $catList = '<select name="categoryId" id="categoryId">';
    foreach ($categories as $category) {
        // For each category, add an option value with the ID as the value and the name as the display value
        $catList .= '<option value="'.urlencode($category['categoryId']).'">'.urlencode($category['categoryName']).'</option>';
    }
    // Close the select box
    $catList .= '</select>';
    // Return the completed select box
    return $catList;
}

/*
 * buildCategoryListWithProdInfo($prodInfo) will build a select box with a list
 *  of valid categories to be used in forms, with the category related to a particular
 * product preselected
 */

function buildCategoryListWithProdInfo($prodInfo) {
    // Get the list of categories from the getCategories function
    $categories = getCategories();
    // Create the categories select list
    $catList = '<select name="catType" id="catType">';
    // Add non-valued option for "Choose a catevory"
    $catList .= "<option>Choose a Category</option>";
    foreach ($categories as $category) {
        if(isset($invId)) {
            // If the invId variable is set, us it to get the product info for that ID
            $prodInfo = getProductInfo($invId);
        }
        //Create the option value with the Category ID as the value
        $catList .= "<option value='$category[categoryId]'";
        if(isset($catType)){
            // If catType is set, then,
            if($category['categoryId'] === $catType){
                // If categoryId for this product matches catType, mark that option as selected
                $catList .= ' selected ';
            } // otherwise do nothing with catType
        } elseif(isset($prodInfo['categoryId'])){
            // If prodInfo categoryId is set, then
            if($category['categoryId'] === $prodInfo['categoryId']){
                // if prodInfo categoryId matchs the category categoryId, mark that option as selected
                $catList .= ' selected ';
            } // otherwise, do nothing
        }
        // set the visible value andd close the option list
        $catList .= ">$category[categoryName]</option>";
    }
    // Close the select box
    $catList .= '</select>';
    // Return the select box
    return $catList;
}

/*
 * newCategory($categoryName) will add a new category to the database
 */

function newCategory($categoryName){
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO categories (categoryName) VALUES ( :categoryName )';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);    
    // Execute the statement
    $stmt->execute();
    // Get the number of rows changed
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the number of rows changed
    return $rowsChanged;
}

/*
 * newProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle) 
 * will add a new product to the database
 */

function newProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle){
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO inventory (invName, invDescription, invImage, invThumbnail, invPrice, invStock, invSize, invWeight, invLocation, categoryId, invVendor, invStyle)
        VALUES (:invName, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invSize, :invWeight, :invLocation, :categoryId, :invVendor, :invStyle)';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable values to the placeholders in the above SQL statement
    $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invSize', $invSize, PDO::PARAM_STR);
    $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_STR);
    $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_STR);
    $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
    // Execute the statement
    $stmt->execute();
    // Get the number of rows changed
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the number of rows changed
    return $rowsChanged;
}

/*
 * getProductBasics() will retrieve product name and ID from the database
 */

function getProductBasics() {
    
    // Create a connection object from the acme connection function
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = 'SELECT invName, invId FROM inventory ORDER BY invName ASC';
    // The next line creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next line runs the prepared statement
    $stmt->execute();
    // The next line gets the data from the database and stores it as an array in the $products variable
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // The next line closes the interaction with the database
    $stmt->closeCursor();
    // The next line sends the array of data back to where the function was called (this should be the controller)
    return $products;
}

/*
 * getProductInfo($invId) will retrieve product info from the database based on an invId
 */

function getProductInfo($invId){
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the array
    return $prodInfo;
}

/*
 * updateProduct($catType, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle, $invId)
 * will update an existing product in the database
 */

function updateProduct($catType, $invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle, $invId) {
    // Create a connection
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = 'UPDATE inventory SET invName = :invName, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invSize = :invSize, invWeight = :invWeight, invLocation = :invLocation, categoryId = :catType, invVendor = :invVendor, invStyle = :invStyle WHERE invId = :invId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable values to the placeholders in the above SQL statement
    $stmt->bindValue(':catType', $catType, PDO::PARAM_INT);
    $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invSize', $invSize, PDO::PARAM_INT);
    $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
    $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
    $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    // Execute the statement
    $stmt->execute();
    // Get the number of rows changed
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the number of rows changed
    return $rowsChanged;
}

/*
 * deleteProduct($invId) will delete an existing product in the database based on invId
 */

function deleteProduct($invId) {
    // Create a connection
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    // Execute the statement
    $stmt->execute();
    // Get the number of rows changed
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the number of rows changed
    return $rowsChanged;
}

/*
 * getProductsByCategory($type) will retrieve product info from the database based on an category
 */

function getProductsByCategory($type) {
    // Create a connection
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = 'SELECT * FROM inventory WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :catType)';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':catType', $type, PDO::PARAM_STR);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the array
    return $products;    
}

/*
 * getProductDetails($invId) will retrieve product info from the database based on an invId
 */

function getProductDetails($invId){
    // Create a connection
    $db = acmeConnect();
    // The SQL statement to be used with the database
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the array
    return $products;    
}