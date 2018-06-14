<?php
    /*
     * Accounts Controller
     */

    // Create or access a Session
    session_start();
    
    // Get the database connection file
    require_once '../library/connections.php';
    // Get the acme model for use as needed
    require_once '../model/acme-model.php';
    // Get the accounts model
    require_once '../model/accounts-model.php';
    // Get the functions library
    require_once '../library/functions.php';
    require_once '../model/reviews-model.php';
    
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }
    switch ($action){
        case 'register':
            include '../view/register.php';
            break;
        case 'admin':
            include '../view/admin.php';
            break;
        case 'registration':
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
            $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);
            
            $existingEmail = checkExistingEmail($clientEmail);
            
            // Check for existing email address in the table
            if($existingEmail){
                $message = '<p class="notice">Email address already on file. Please login instead.</p>';
                include '../view/login.php';
                exit;
            }
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
                setcookie('firstname', $clientFirstname, strtotime('+1 week'), '/');
                $message = "<p>Thank you, $clientFirstname! You have successfully registered. Please log in.</p>";                
                include '../view/login.php';
                exit;
            } else {
                $message = 'Sorry $clientFirstname, registration was unsuccessful.';
                include '../view/register.php';
                exit;
            }
        case 'Login':
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientEmail = checkEmail($clientEmail);
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
            $passwordCheck = checkPassword($clientPassword);

            // Run basic checks, return if errors
            if (empty($clientEmail) || empty($passwordCheck)) {
                $message = '<p class="notice">Please provide a valid email address and password.</p>';
                include '../view/login.php';
                exit;
            }

            // A valid password exists, proceed with the login process
            // Query the client data based on the email address
            $clientData = getClient($clientEmail);
            // Compare the password just submitted against
            // the hashed password for the matching client
            $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
            // If the hashes don't match create an error
            // and return to the login view
            if(!$hashCheck) {
              $message = '<p class="notice">Please check your password and try again.</p>';
              include '../view/login.php';
              exit;
            }
            // A valid user exists, log them in
            $_SESSION['loggedin'] = TRUE;
            // Remove the password from the array
            // the array_pop function removes the last
            // element from an array
            array_pop($clientData);
            // Store the array into the session
            $_SESSION['clientData'] = $clientData;
            $_SESSION['firstname'] = $clientData['clientFirstname'];
            $_SESSION['lastname'] = $clientData['clientLastname'];
            setcookie('firstname', "", strtotime('+1 week'), '/');
            $clientId = $_SESSION['clientData']['clientId'];
            $clientFirstName = $_SESSION['clientData']['clientFirstname'];
            // Send them to the admin view
            include '../view/admin.php';
            exit;
            break;
        case 'Logout':
            setcookie('firstname', "", strtotime('-1 week'), '/');
            session_destroy();
            //setcookie("firstname", "", time() - 3600);
            header('location:/acme/index.php');
            exit;
            
        case 'client-update':
            include '../view/client-update.php';
            break;
        case 'updateClient':
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
            $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            if (empty($clientId) || empty($ClientFirstname) || empty($clientLastname) || empty($clientEmail)) {
                $message = '<p>Please complete all the information</p>';
            }
            $updateClientInfo = updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail);
            if ($updateClientInfo) {
                $message = "<p>Congratulations $clientFirstname, your account was sucessfully updated.</p>";
                $_SESSION['message'] = $message;
                $_SESSION['clientData'] = $clientData;
                $_SESSION['firstname'] = $clientData['clientFirstname'];
                $_SESSION['lastname'] = $clientData['clientLastname'];
                setcookie('firstname', "", strtotime('+1 week'), '/');
                $clientId = $_SESSION['clientData']['clientId'];
                $clientFirstName = $_SESSION['clientData']['clientFirstname'];
                include '../view/admin.php';

                exit;
            } else {
                $message = "<p>Error. $ClientFirstname was not updated.</p>";
                $_SESSION['message'] = $message;
                 include '../view/admin.php';
                exit;
            }
            break;
        case 'updatePassword':
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
            $passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_STRING);
            if (empty($clientId) || empty($clientPassword)) {
                $message = '<p>Please complete all the information</p>';
            }
            if($clientPassword === $passwordConfirm) {
                $clientPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
                $clientPasswordUpdated = updatePassword($clientId, $clientPassword);
            } else {
                $message = "<p>Passwords do not match. Please try again.</p>";
                $_SESSION['message'] = $message;
                include '../view/client-update.php';
                exit;
            }
            if ($clientPasswordUpdated) {
                $message = "<p>Congratulations your password was sucessfully updated.</p>";
                $_SESSION['message'] = $message;
                include '../view/admin.php';
                exit;
            } else {
                $message = "<p>Client ID is $clientId  - Error. Your password was not updated.</p>";
                $_SESSION['message'] = $message;
                include '../view/admin.php';
                exit;
            }
            case 'loggedin':
                if (isset($_SESSION['loggedin'])) {
                    $clientId = $_SESSION['clientData']['clientId'];
                    $clientFirstName = $_SESSION['clientData']['clientFirstname'];
                    $clientRevName = substr($clientFirstName, 0, 1) . $_SESSION['clientData']['clientLastname'];
                    $clientReviewsArray = getReviewByClient($clientId);
                    if (isset($clientReviewsArray)) {
                        $reviewList = buildClientRevsDisplay($clientReviewsArray, $clientRevName);
                    }
                    include '../view/admin.php';
                    exit;
                } else {
                    header("Location: /acme/");
                    exit;
                }
                break;
            default:
                include '../view/login.php';
                break;
       }
?>