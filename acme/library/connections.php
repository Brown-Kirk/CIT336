<?php

/*
 *  Database Connection
 */

// Copied from the lesson - too tired to comment. It connects to the database. :-)
function acmeConnect(){
    $server = 'localhost';
    $dbname= 'acme';
    $username = 'iClient';
    $password = 'TBuVrwbJjT6BUZQQ';
    $dsn = 'mysql:host='.$server.';dbname='.$dbname;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    // Create the actual connection object and assign it to a variable
    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    } catch(PDOException $e) {
        header('location: /acme/view/500.php');
        exit;
    }
}