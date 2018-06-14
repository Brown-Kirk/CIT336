<?php

/* 
 * Uploads model
 */

/*
 * storeImages($imgPath, $invId, $imgName) will add image entries into the database for both full size and thumbnails
 */

function storeImages($imgPath, $invId, $imgName) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO images (invId, imgPath, imgName) VALUES (:invId, :imgPath, :imgName)';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable values to the placeholders in the above SQL statement
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    // Execute the statement
    $stmt->execute();
    // Change the image name in the full path to indicate thumbnail
    $imgPath = makeThumbnailName($imgPath);
    // Change the image name in just the filename to indicate thumbnail
    $imgName = makeThumbnailName($imgName);
    // Bind the variable values to the placeholders in the above SQL statement
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
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
 * getImages() will retrieve all image entries from the database
 */

function getImages() {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invName FROM images JOIN inventory ON images.invId = inventory.invId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the array
    return $imageArray;
}

/*
 * deleteImage($id) will delete a particular image entry from the database
 */

function deleteImage($id) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'DELETE FROM images WHERE imgId = :imgId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':imgId', $id, PDO::PARAM_INT);
    // Execute the statement
    $stmt->execute();
    // Get the number of rows changed
    $result = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the number of rows changed
    return $result;
}

/*
 * checkExistingImage($imgName) checks if an existing image file name already exists in the database
 */

function checkExistingImage($imgName){
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = "SELECT imgName FROM images WHERE imgName = :name";
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $imageMatch = $stmt->fetch();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the number of rows changed
    return $imageMatch;
}

/*
 * getThumbnails($prodId) retrieves all thumbnail image names from the database
 */

function getThumbnails($prodId) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = "SELECT * FROM images WHERE imgName LIKE '%-tn.%' AND invId = $prodId";
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $imageArray = $stmt->fetchAll(PDO::FETCH_NAMED);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the number of rows changed
    return $imageArray;
}