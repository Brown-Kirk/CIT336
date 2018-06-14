<?php
    /*
     * Accounts Controller
     */

    // Create or access a Session
    session_start();
    
    // Get the database connection file
    require_once '../library/connections.php';
    // Get the acme model 
    require_once '../model/acme-model.php';
    // Get the accounts model
    require_once '../model/accounts-model.php';
    // Get the functions library
    require_once '../library/functions.php';
    // Get the reviews model
    require_once '../model/reviews-model.php';
    
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }
    switch ($action){
        case 'register':
            // Go to account registration page
            include '../view/register.php';
            break;
        case 'admin':
            // Go to administration page
            include '../view/admin.php';
            break;
        case 'registration':
            // Process completed registration form
            // Filter input values to remove invalid characters and values
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
            $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
            // Verify email is valid format
            $clientEmail = checkEmail($clientEmail);
            // Verify password meets minimum requirements
            $checkPassword = checkPassword($clientPassword);
            // Verify email does not already exist in database
            $existingEmail = checkExistingEmail($clientEmail);
            
            if($existingEmail){
                // If email already exists in database, notify to login instead
                $message = '<p class="notice">Email address already on file. Please login instead.</p>';
                // Reroute to login page
                include '../view/login.php';
                exit;
            }
            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
                if(empty($clientFirstname)) {
                    // If empty fields and no first name provide, set message and send back to registration page
                    $message = '<p>Please provide information for all empty form fields.</p>';
                    include '../view/register.php';
                    exit;
                } else {
                    // If empty fields, but first name is present, set personalized messge and send back to registration page
                    $message = "<p>Sorry, $clientFirstname, you must fill out all fields.</p>";
                exit; 
                }
            }
            // Create hashed password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
            // Register user's account, return 0 if fail, 1 if success
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
            if($regOutcome ===1) {
                // If successful, set cookie for first name, valid for 1 week
                setcookie('firstname', $clientFirstname, strtotime('+1 week'), '/');
                // Set success message
                $message = "<p>Thank you, $clientFirstname! You have successfully registered. Please log in.</p>";                
                // Route to login page
                include '../view/login.php';
                exit;
            } else {
                // Notify of failure
                $message = 'Sorry $clientFirstname, registration was unsuccessful.';
                // Return user to registration page
                include '../view/register.php';
                exit;
            }
        case 'Login':
            // Get email from input and sanitize
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            // Sanitize and validate email
            $clientEmail = checkEmail($clientEmail);
            // Get password and sanitize string
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
            // Check for password minimum requirements
            $passwordCheck = checkPassword($clientPassword);

            // Verify email and password provided
            if (empty($clientEmail) || empty($passwordCheck)) {
                // If either not provided, return to login page
                $message = '<p class="notice">Please provide a valid email address and password.</p>';
                include '../view/login.php';
                exit;
            }
            // Using email address, retrieve client data
            $clientData = getClient($clientEmail);
            // Verify password against hashed password from database
            $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
            // If passwords don't match, set error message and return to login screen
            if(!$hashCheck) {
              $message = '<p class="notice">Please check your password and try again.</p>';
              include '../view/login.php';
              exit;
            }
            // Set logged in session value to true
            $_SESSION['loggedin'] = TRUE;
            // Remove the last element (password) from the array
            array_pop($clientData);
            // Set session values
            $_SESSION['clientData'] = $clientData;
            $_SESSION['firstname'] = $clientData['clientFirstname'];
            $_SESSION['lastname'] = $clientData['clientLastname'];
            // Set firstname cookie value
            setcookie('firstname', "", strtotime('+1 week'), '/');
            // Define client ID
            $clientId = $_SESSION['clientData']['clientId'];
            // Define first name
            $clientFirstName = $_SESSION['clientData']['clientFirstname'];
            // Send them to the admin view
            include '../view/admin.php';
            exit;
            break;
        case 'Logout':
            // Expire firstname cookie
            setcookie('firstname', "", strtotime('-1 week'), '/');
            // End session
            session_destroy();
            // Route back to main home page
            header('location:/acme/index.php');
            exit;
            
        case 'client-update':
            // Route to Client update page
            include '../view/client-update.php';
            break;
        case 'updateClient':
            // Filter input values to remove invalid characters and values
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
            $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            if (empty($clientId) || empty($ClientFirstname) || empty($clientLastname) || empty($clientEmail)) {
                // If any fields are missing, set error message and return to client-update page
                $message = '<p>Please complete all the information</p>';
                include '../view/client-update.php';
                exit;
            }
            // Update database with provided information
            $updateClientInfo = updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail);
            if ($updateClientInfo) {
                // If successful, set personalized success message
                $message = "<p>Congratulations $clientFirstname, your account was sucessfully updated.</p>";
                // Set session values
                $_SESSION['message'] = $message;
                $_SESSION['clientData'] = $clientData;
                $_SESSION['firstname'] = $clientData['clientFirstname'];
                $_SESSION['lastname'] = $clientData['clientLastname'];
                // Set first name cookie with updated first name
                setcookie('firstname', "", strtotime('+1 week'), '/');
                // Define Client ID
                $clientId = $_SESSION['clientData']['clientId'];
                // Define Client First Name
                $clientFirstName = $_SESSION['clientData']['clientFirstname'];
                // Route to admin page
                include '../view/admin.php';
                exit;
            } else {
                // Set error message and route to admin page
                $message = "<p>Error. $ClientFirstname was not updated.</p>";
                $_SESSION['message'] = $message;
                 include '../view/admin.php';
                exit;
            }
        case 'updatePassword':
            // Filter input values to remove invalid characters and values
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
            $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
            $passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_STRING);
            if (empty($clientId) || empty($clientPassword)) {
                // Set error message and return to update page
                $message = '<p>Please complete all the information</p>';
                $_SESSION['message'] = $message;
                include '../view/client-update.php';
                exit;
            }
            // Verify password and confirm password match
            if($clientPassword === $passwordConfirm) {
                // Hash password
                $clientPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
                // Update hashed password in database
                $clientPasswordUpdated = updatePassword($clientId, $clientPassword);
            } else {
                // Set error message and return to client update page
                $message = "<p>Passwords do not match. Please try again.</p>";
                $_SESSION['message'] = $message;
                include '../view/client-update.php';
                exit;
            }
            if ($clientPasswordUpdated) {
                // If password updated successfully, set success message and send to admin page
                $message = "<p>Congratulations your password was sucessfully updated.</p>";
                $_SESSION['message'] = $message;
                include '../view/admin.php';
                exit;
            } else {
                // If password update failed, set error message and return to admin page
                $message = "<p>Client ID is $clientId  - Error. Your password was not updated.</p>";
                $_SESSION['message'] = $message;
                include '../view/admin.php';
                exit;
            }
            case 'loggedin':
                // Check if loggedin session variable has been set
                if (isset($_SESSION['loggedin'])) {
                    // Get Client ID
                    $clientId = $_SESSION['clientData']['clientId'];
                    // Get Client first name
                    $clientFirstName = $_SESSION['clientData']['clientFirstname'];
                    // Set username for reviews (fist initial plus last name)
                    $clientRevName = substr($clientFirstName, 0, 1) . $_SESSION['clientData']['clientLastname'];
                    // Get product reviews by logged in user
                    $clientReviewsArray = getReviewByClient($clientId);
                    if (isset($clientReviewsArray)) {
                        // If reviews exist, build review display section
                        $reviewList = buildClientRevsDisplay($clientReviewsArray, $clientRevName);
                    }
                    // Send to admin page
                    include '../view/admin.php';
                    exit;
                } else {
                    // If not logged in, return to home page
                    header("Location: /acme/");
                    exit;
                }
                break;
            default:
                // Send to login page
                include '../view/login.php';
                break;
       }
?>