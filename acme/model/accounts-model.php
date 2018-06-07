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
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
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

    // Close DB connection
    $stmt->execute();

    // Set variable matchEmail to the value(s) returned  from SQL execution
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close DB connection
    $stmt->closeCursor();

    // Return $clientData values
    return $clientData;
}

function updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail){
    $db = acmeConnect();
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, clientEmail = :clientEmail WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
 }
   
function updatePassword($clientId, $clientPassword) {
    $db = acmeConnect();
    $sql = 'UPDATE clients SET clientPassword = :clientPassword WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}   