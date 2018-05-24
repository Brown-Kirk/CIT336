<?php
    /*
     * Accounts Controller
     */
    // Get the database connection file
    require_once '../library/connections.php';
    // Get the acme model for use as needed
    require_once '../model/acme-model.php';
    // Get the accounts model
    require_once '../model/accounts-model.php';
    
    $categories = getCategories();
    $navList = buildNav();
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }
    switch ($action){
        case 'register':
            include '../view/register.php';
            break;
        case 'registration':
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname');
            $clientLastname = filter_input(INPUT_POST, 'clientLastname');
            $clientEmail = filter_input(INPUT_POST, 'clientEmail');
            $clientPassword = filter_input(INPUT_POST, 'clientPassword');
            
            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientPassword)){
                if(empty($clientFirstname)) {
                    $message = '<p>Please provide information for all empty form fields.</p>';
                    include '../view/register.php';
                    exit;
                } else {
                $message = "<p>Sorry, $clientFirstname, you must fill out all fields.</p>";
                exit; 
                }
            }
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword);
            if($regOutcome ===1) {
                $message = "<p>Thank you, $clientFirstname! You have successfully registered. Please log in.</p>";                
                include '../view/login.php';
                exit;
            } else {
                $message = 'Sorry $clientFirstname, registration was unsuccessful.';
                include '../view/register.php';
                exit;
            }
        case 'login':
            include '../view/login.php';
            break;
        default:
            include '../view/login.php';
            break;
   }
?>