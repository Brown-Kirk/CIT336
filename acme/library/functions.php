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
    return $pd;
}

//function to build a display of product information
function buildProdThumbnails($prodThumbnails) {
    if( $prodThumbnails == NULL ) {
        //do nothing
    } else {
        $pd = "<hr>";
        $pd .= "<h2>Additional Images</h2>";
        foreach ($prodThumbnails as $thumbnail) {
            $pd .= "<img src='$thumbnail[imgPath]' alt='Thumbnail Image of $thumbnail[imgName] on Acme.com'><br>";
        }
        
        $pd .= "</section>";
        return $pd;
    }
}

/* * ********************************
* Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<img src='$image[imgPath]' title='$image[invName] image on Acme.com' alt='$image[invName] image on Acme.com'>";
        $id .= "<p><a href='/acme/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}

// Build the products select list
function buildProductsSelect($products) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Product</option>";
    foreach ($products as $product) {
        $prodList .= "<option value='$product[invId]'>$product[invName]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
         return;
        }
        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;
        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);
        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        // Returns the path where the file is stored
        return $filepath;
    }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';

    // Set up the image path
    $image_path = $dir . $filename;

    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);

    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);

    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {

    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    }

    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {

        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height_long = $old_height / $ratio;
        $new_width_long = $old_width / $ratio;
        $new_height = round($new_height_long);
        $new_width = round($new_width_long);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
     } else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
     }
     // Free any memory associated with the old image
     imagedestroy($old_image);
}

