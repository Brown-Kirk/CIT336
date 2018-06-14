<?php
    /*
     * Reviews Controller
     */

    // Create or access a Session
    session_start();
    // Get the various function libraries
    require_once '../library/connections.php';
    require_once '../model/acme-model.php';
    require_once '../model/accounts-model.php';
    require_once '../library/functions.php';
    require_once '../model/products-model.php';
    require_once '../model/reviews-model.php';
    require_once '../model/uploads-model.php';
    // Get the array of categories
    $categories = getCategories();
    // Build a navigation bar using the $categories array
    buildNav();
    // Check to see if the "action" value was posted
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        // If no action value was posted, attempt to get it
        $action = filter_input(INPUT_GET, 'action');
    }
    // Select course of action based on $action variable      
    switch ($action) {
        case 'addReview':
            // If action is "addReview", then get variables from previous form
            $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
            $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
            $prodId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
            // Check if reviewText is empty
            if (empty($reviewText)) {
                // If reviewText is empty, set error message accordingly
                $message = '<p>Please provide information for all empty form fields.</p>';
                // Return to product detail view
                include '../view/prod-detail.php';
                exit;
            }
            // Add review to database using insertReview function
            $reviewOutcome = insertReview($reviewText, $invId, $clientId);
            // Check for value for rows returned
            if ($reviewOutcome === 1) {
                // If one row was returned, set success message
                $message = "<p>Thanks for adding a review to the product.</p>";
                // Retrieve product details from the database based on invId using getProductDetails function
                $product = getProductDetails($invId);
                // Retreive product thumbnail list using getThumbnails function
                $prodThumbnails = getThumbnails($invId);
                // If no product is returned
                if(!count($product)){
                    // Set error message accordingly
                    $message = "<p class='notice'>Sorry, no $prodId could be found.</p>";
                } else {
                    // If product is returned, build product detail for page
                    $prodDetail = buildProductsDetail($product);
                    // Build thumbnail display for page
                    $thumbnails =buildProdThumbnails($prodThumbnails);
                }
                // Clear out review text variable
                $reviewText = '';
                // Include the product detail view
                include '../view/prod-detail.php';
                exit;
            } else {
                //If no rows were returned, set error message
                $message = "<p>Sorry, but the creation of a new product review failed. Please try again.</p>";
                // Include product detail view
                include '../view/prod-detail.php';
                exit;
            }
        case 'editReview':
            // If action is "editReview", get the id from the previous form
            $reviewId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            // Use getReview function to retrieve the appropriate review
            $reviewInfo = getReview($reviewId);
            // Set reviewText variable to the reviewText value from database
            $reviewText = $reviewInfo['reviewText'];
            // Set invId variable to the invId value from database
            $invId = $reviewInfo['invId'];
            // If the numebr of reviews is less than 1
            if (count($reviewInfo) < 1) {
                // set error message
                $message = 'Sorry, no product information could be found.';
            }
            // Include the update review view
            include '../view/review-update.php';
            exit;
        case 'updateReview':
            // If action is "updateReview", get variables from previous form
            $reviewText = filter_input(INPUT_POST, 'reviewtext', FILTER_SANITIZE_STRING);
            $reviewId = filter_input(INPUT_POST, 'reviewid', FILTER_SANITIZE_NUMBER_INT);
            $invId = filter_input(INPUT_POST, 'invid', FILTER_SANITIZE_NUMBER_INT);
            // Check for empty variables
            if (empty($reviewText) || empty($reviewId)) {
                // If any fields were empty, set error message accordingly
                $message = '<p>Please provide complete and correct information for all item fields!</p>';
                // Return them to the review-update view
                include '../view/review-update.php';
                exit;
            }
            // Update the review in the database using the updateReview function
            $updateResult = updateReview($reviewId, $reviewText);
            // Check for rows returned
            if ($updateResult) {
                // If any rows were returned, set success message
                $message = "<p class='notice'>Congratulations, the review was successfully updated.</p>";
                // Set message as a session variable
                $_SESSION['message'] = $message;
                // Include the admin view
                include '../view/admin.php';
                exit;
            } else {
                // If no rows were returned, set error message accordingly
                $message = "<p class='notice'>Error. The review was not updated.</p>";
                // Include the review update view
                include '../view/review-update.php';
                exit;
            }
        case 'deleteReview':
            // If action is "deleteReview", get id from previous form
            $reviewId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            // Retrieve review using getReview function
            $reviewInfo = getReview($reviewId);
            // Set reviewText variable to reviewText from database
            $reviewText = $reviewInfo['reviewText'];
            // Set invId variable to invId from database
            $invId = $reviewInfo['invId'];
            // Retrieve product name using getProductName function
            $invReviewNameInfo = getProductName($invId);
            // Check number of reviews retrieved
            if (count($reviewInfo) < 1) {
                // If less than one review, set error message accordingly
                $message = "<p class='notice'>Sorry, no review information could be found.</p>";
            }
            // Include the delete review view
            include '../view/review-delete.php';
            exit;
        case 'delete':
            // If action is "delete", get reviewId from previous form
            $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
            // Use getReview function to retrieve review from database
            $reviewInfo = getReview($reviewId);
            // Set invId value to invId from database
            $invId = $reviewInfo['invId'];
            // Retrieve product name using getProductName function
            $invReviewNameInfo = getProductName($invId);
            // Set product name
            $invReviewName = $invReviewNameInfo['invName'];
            // Delete review from database using the deleteReview function
            $deleteResult = deleteReview($reviewId);
            // Check rows returned
            if ($deleteResult) {
                // If rows returned, set success message
                $message = "<p class='notice'>Congratulations! The " . $invReviewName . " review was successfully deleted.</p>";
                // Set message as a session message
                $_SESSION['message'] = $message;
                // Include the admin view
                include '../view/admin.php';
                exit;
            } else {
                // If no rows returend, set error message
                $message = "<p class='notice'>Error. The " . $invReviewName . " review was not deleted.</p>";
                // Include delete review view
                include '../view/review-delete.php';
                exit;
            }
        case 'default':
            // If no action set, check if user is logged in
            if (isset($_SESSION['loggedin'])) {
                // If logged in, include admin view
                include '../view/admin.php';
                exit;
            } else {
                // If not logged in, return to home page
                header("Location: /acme/");
                exit;
            }
    }