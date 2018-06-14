<?php

/* 
 * Accounts model
 */

/*
 * regClient() will handle site registrations
 */

function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword) {
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
        VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind the variable values to the placeholders in the above SQL statement
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
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
 * checkExistingEmail() will handle check if email adddress already registered
 */

function checkExistingEmail($clientEmail){
    // Create database connection
    $db = acmeConnect();
    // SQL statement selecting matching email address from database
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    // Create the prepared statment using the acme connection
    $stmt = $db->prepare($sql);
    // Bind variable to value for email address
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    // Execute the SQL statement
    $stmt->execute ();
    // Set variable matchEmail to the value(s) returned  from SQL execution
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    // Close DB connection
    $stmt->closeCursor();
    // Check to see if matchEmail is empty - if so, return 0, otherwise return 1
    if (empty($matchEmail)){
        return 0;
    } else {
        return 1;
    }
}
  
 /*
 * getClient($email) Fetches client data based on email address entered
 */

function getClient($email){
    // Create database connection
    $db = acmeConnect();
    // SQL statement selecting client info matching logged in email address
    $sql = 'SELECT * 
            FROM clients 
            WHERE clientEmail = :email';
    // Create the prepared statment using the acme connection
    $stmt = $db->prepare($sql);
    // Bind variable to value for email address
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    // Close DB connection
    $stmt->execute();
    // Set variable matchEmail to the value(s) returned  from SQL execution
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close DB connection
    $stmt->closeCursor();
    // Return $clientData values
    return $clientData;
}
 
/*
 * getClientById($clientId) Fetches client data based on clientId entered
 */

function getClientById($clientId) {
    // Create database connection
    $db = acmeConnect();
    // SQL statement selecting client info matching logged in email address
    $sql = 'SELECT * 
            FROM clients 
            WHERE clientId = :clientId';
    // Create the prepared statment using the acme connection
    $stmt = $db->prepare($sql);
    // Bind variable to value for email address
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    // Execute statement
    $stmt->execute();
    // Set variable matchEmail to the value(s) returned  from SQL execution
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close DB connection
    $stmt->closeCursor();
    // Return $clientData values
    return $clientData;
}

/*
 * updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail) 
 * updates client data based on values provided
 */

function updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail){
    // Create database connection
    $db = acmeConnect();
    // SQL statement updating fields to newly provided values
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, clientEmail = :clientEmail WHERE clientId = :clientId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind variables to values
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    // Execute statement
    $stmt->execute();
    // Get number of rows changed
    $rowsChanged = $stmt->rowCount();
    // Close DB connection
    $stmt->closeCursor();
    // Return number rows changed
    return $rowsChanged;
 }

/*
 * updatePassword($clientId, $clientPassword) 
 * updates password based on values provided
 */
 
function updatePassword($clientId, $clientPassword) {
    // Create database connection
    $db = acmeConnect();
    // SQL statement updating password to newly provided values
    $sql = 'UPDATE clients SET clientPassword = :clientPassword WHERE clientId = :clientId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // Bind variables to values
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    // Execute statement
    $stmt->execute();
    // Get number of rows changed
    $rowsChanged = $stmt->rowCount();
    // Close DB connection
    $stmt->closeCursor();
    // Return number rows changed
    return $rowsChanged;
}   