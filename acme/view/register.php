<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Acme - Register"; include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
    </head>
    <body>
        <header>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/header.php';
            ?>
        </header>
        <nav class="nav">
            <?php echo $navList; ?>
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
                        <input type="text" name="clientFirstname" id="clientFirstname">
                        <br>
                    </label>

                    <label>
                        Last name:<br>
                        <input type="text" name="clientLastname" id="clientLastname">
                        <br>
                    </label>

                    <label>
                        Email address:<br>
                        <input type="email" name="clientEmail" id="clientEmail">
                        <br>
                    </label>

                    <label>
                        Password:<br>
                        <input type="password" name="clientPassword" id="clientPassword">
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
