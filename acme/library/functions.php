<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function checkEmail($email) {
    
    //Remove any illegal characters from the email variable
    $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    //Verify that the new sanitizedEmail variable is a valid email address
    $validatedEmail = filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL);

    //return the validated email address
    return $validatedEmail;
}

function checkPassword($password) {
    /*
     * Check the password for a minimum of 8 characters, and one or more of each of the following: 
     * upper case, lower case, number, special character
     */
    
    //Define the pattern to be matched
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])[[:print:]]{8,}$/';
    
    //Compare the pattern and the password and return boolean
    return preg_match($pattern, $password);
}

function getCategories() {
    
    // Create a connection object from the acme connection function
    $db = acmeConnect();

    // The SQL statement to be used with the database
    $sql = 'SELECT categoryName, categoryId FROM categories ORDER BY categoryName ASC';

    // The next line creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);

    // The next line runs the prepared statement
    $stmt->execute();

    // The next line gets the data from the database and stores it as an array in the $categories variable
    $categories = $stmt->fetchAll();

    // The next line closes the interaction with the database
    $stmt->closeCursor();

    // The next line sends the array of data back to where the function was called (this should be the controller)
    return $categories;
}



function buildProductsDisplay($products) {
    
    $pd = '<ul id="prod-display">';
    foreach ($products as $product) {
        
        $pd .='<li>';
        $pd .= "<a href='/acme/products/index.php?action=prod-detail&id=$product[invId]'><img src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'>";
        $pd .= '<hr>';
        $pd .= "<h2>$product[invName]</h2></a>";
        $pd .= "<p>$$product[invPrice]</p>";
        $pd .= '</li>';
    }
    
    $pd .= '</ul>';
    return $pd;
    
}

function buildProductsDetail($product) {
    
    $pd = "<section id='prod-image'>";
    $pd .= "<img src='$product[invImage]' alt='Image of $product[invImage] on Acme.com'><br>";
    $pd .= "</section>";
    $pd .= "<section id='prod-details'>";
    $pd .= "<h1>$product[invName]</h1>";
    $pd .= "<h2>Price: $$product[invPrice]</h2>";
    $pd .= "$product[invDescription]<br><br>";
    $pd .= "Size: $product[invSize]<br>";
    $pd .= "Weight: $product[invWeight]<br>";
    $pd .= "Quantity: $product[invStock]<br>";
    $pd .= "Location: $product[invLocation]<br>";
    $pd .= "Style: $product[invStyle]<br>";
    $pd .= "Vendor: $product[invVendor]";
    $pd .= "</section>";
    return $pd;
}
