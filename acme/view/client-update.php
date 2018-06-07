<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location:/index.php');
    exit;
}
$clientData=$_SESSION['clientData'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $pageTitle="Acme - Account Update";
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; 
        ?>    
    </head>
    <body>
        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/header.php';
        ?>
        <nav class="nav">
            <?php 
                echo buildNav() 
            ?>
        </nav>
        <main>
            <section id='message'>
                <?php
                    if (isset($message)) {
                        echo "<br> $message <br>";
                        unset ($_SESSION['message']);
                    }
                ?>
            </section>
            <h1>Update Account</h1>
            <p>Please edit the fields below to update your account. </p>
            <section id="clientUpdateForm">
                <form action="/acme/accounts/index.php?action=updateClient" method="post">
                    <fieldset>
                        <label>First Name:</label><br>
                        <input type="text" name="clientFirstname" id="clientFirstname" required
                        <?php if (isset($clientFirstname)) {echo "value='$clientFirstname'";}
                        elseif(isset($clientData['clientFirstname'])) {echo "value='$clientData[clientFirstname]'"; }?>><br>

                        <label>Last Name:</label><br>
                        <input type="text" name="clientLastname" id="clientLastname" required
                        <?php if (isset($clientLastname)) {echo "value='$clientLastname'";}
                        elseif(isset($clientData['clientLastname'])) {echo "value='$clientData[clientLastname]'"; }?>><br>

                        <label>Email Address:</label><br>
                        <input type="text" name="clientEmail" id="clientEmail" required
                            <?php 
                                if (isset($clientEmail)) {
                                    echo "value='$clientEmail'";
                                }
                                elseif(isset($clientData['clientEmail'])) {
                                    echo "value='$clientData[clientEmail]'>"; 
                                }
                            ?>
                        <br>
                        <input type="hidden" name="clientId" value="<?php if (isset($clientData['clientId'])) {echo $clientData['clientId'];} elseif (isset($clientId)) {echo $clientId;} ?>">
                        <br>
                        <input type="submit" name="submit" value="Update Information">
                        <input type="hidden" name="action" value="updateClient">
                    </fieldset>
                </form>                
            </section>

            <section id="passwordUpdateForm">
                <form action="/acme/accounts/index.php?action=updatePassword" method="post">
                    <fieldset>
                        <h1>Change Password</h1>
                        <p> Enter your new password below. </p>
                        <span><i>Passwords must be at least 8 characters and contain at least one upper case, one lower case, one number, and one special character</i></span><br>
                            <label>
                                <br>Password:<br>
                                
                                <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                            </label>
                            <label>
                                <br>Confirm:<br>
                                <input type="password" name="passwordConfirm" id="passwordConfirm" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                            </label>
                        <label>
                        <br><br>
                        <input type="submit" name="submit" value="Update Password">
                        <input type="hidden" name="action" value="updatePassword">
                        <input type="hidden" name="clientId" value="<?php if (isset($clientData['clientId'])) {echo $clientData['clientId'];} elseif (isset($clientId)) {echo $clientId;} ?>">
                        </label>
                    </fieldset>
                </form>                
            </section>
        </main>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>