<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Acme - Account Registration"; include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
    </head>
    <body>
        <header>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/header.php';
            ?>
        </header>
        <nav class="nav">
            <?php echo buildNav(); ?>
        </nav>
        <main>
            <div class="login">
                <form method="post" action="/acme/accounts/index.php" method="post">
                    <div class="error">
                        <!--php code if message is set-->
                        <?php
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>
                        <!--end php-->
                    </div>
                    <h1>Acme Registration</h1>
                    <p> All fields required </p>
                    <label>
                        First name:<br>
                        <input type="text" name="clientFirstname" id="clientFirstname" 
                            <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> required>
                        <br>
                    </label>

                    <label>
                        Last name:<br>
                        <input type="text" name="clientLastname" id="clientLastname" 
                            <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?> required>
                        <br>
                    </label>

                    <label>
                        Email address:<br>
                        <input type="email" name="clientEmail" id="clientEmail" 
                            <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required 
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                        <br>
                    </label>

                    <label>
                        Password:<br>
                        <input type="password" name="clientPassword" id="clientPassword" required
                               pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                        <br><span>Passwords must be at least 8 characters and contain at least 1 number, 
                            1 capital letter, and 1 special character</span>
                    </label>
                    <label>
                        <br>
                        <!-- Add the action name - value pair -- >-->
                        <input type="submit" name="submit" id="regbtn" value="Register">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="registration">
                    </label>
                </form>
                <br><br>
                <form action="../accounts/index.php?action=login" method="post">
                    <p>If you already have an account, please click the button below to login.</p>
                    <input type="submit" value="Login" />
                </form>
            </div>
        </main>

        <footer>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
            ?>
        </footer>
    </body>
</html>
