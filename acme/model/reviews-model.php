<?php

/* 
 * Products model
 */

/*
 * insertReview($reviewText, $invId, $clientId) will add a new product review to the database
 */

function insertReview($reviewText, $invId, $clientId) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId) VALUES (:reviewText, :invId, :clientId)';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable values to the placeholders in the above SQL statement
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
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
 * checkExistingReview($clientId, $prodId) will retrieve all existing reviews from the database for a particular client/product combination
 */

function checkExistingReview($clientId, $prodId) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = "SELECT reviewId, reviewText, reviewDate, invId, clientId FROM reviews  WHERE invId = :prodId AND clientId = :clientId";
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable values to the placeholders in the above SQL statement
    $stmt->bindValue(':clientId', $clientId);
    $stmt->bindValue(':prodId', $prodId);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $checkReviewArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the array
    return $checkReviewArray;
}

/*
 * getReviewByClient($clientId) will retrieve all existing reviews from the database for a particular client
 */
      
function getReviewByClient($clientId) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = "SELECT reviews.reviewId, reviews.reviewText, reviews.reviewDate, reviews.clientId, reviews.invId, "
            . "invName FROM inventory INNER JOIN reviews ON reviews.clientId = :clientId AND "
            . "reviews.invId = inventory.invId ORDER BY reviews.reviewDate DESC";
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':clientId', $clientId);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $reviewArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the array
    return $reviewArray;
}

/*
 * getReview($reviewId) will retrieve a particular review from the database by reviewId
 */

function getReview($reviewId) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = "SELECT reviewText, reviewDate, invId, clientId FROM reviews  WHERE reviewId = :reviewId ";
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':reviewId', $reviewId);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $reviewArray = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the array
    return $reviewArray;
}

/*
 * updateReview($reviewId, $reviewText) will update a particular review in the database by reviewId
 */

function updateReview($reviewId, $reviewText) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'UPDATE reviews SET reviewText = :reviewText, reviewDate = NOW() WHERE reviewId = :reviewId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable values to the placeholders in the above SQL statement
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
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
 * getProductName($invId) will retrieve a particular productId from the database by invId
 */

function getProductName($invId) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'SELECT invName FROM inventory WHERE invId = :invId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    // Execute the statement
    $stmt->execute();
    // Get the result of the query as an array
    $nameInfo = $stmt->fetch(PDO::FETCH_NAMED);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the array
    return $nameInfo;
}

/*
 * deleteReview($reviewId) will retrieve a particular review from the database by reviewId
 */

function deleteReview($reviewId) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable value to the placeholder in the above SQL statement
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    // Execute the statement
    $stmt->execute();
    // Get the number of rows changed
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the number of rows changed
    return $rowsChanged;
}