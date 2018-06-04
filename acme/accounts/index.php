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
    // Get the functions library
    require_once '../library/functions.php';

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
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
            $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);
            
            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
                if(empty($clientFirstname)) {
                    $message = '<p>Please provide information for all empty form fields.</p>';
                    include '../view/register.php';
                    exit;
                } else {
                $message = "<p>Sorry, $clientFirstname, you must fill out all fields.</p>";
                exit; 
                }
            }
            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
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
                $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
                $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
                $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
                $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
                $clientEmail = checkEmail($clientEmail);
                $checkPassword = checkPassword($clientPassword);
                break;
            break;
        default:
            include '../view/login.php';
            break;
   }
?>