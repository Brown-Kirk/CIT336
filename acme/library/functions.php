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


