<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Acme - Login"; include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
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
                <!--php code if message is set-->
                  <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <!--end php-->
                <form action="../accounts/index.php?action=login" method="post">
                    <h1>Acme Login</h1>
                    <div class="field">
                        <label for="name">
                            Username:<br>
                            <input type="text" id="name" name="username" required>
                            <br>
                        </label>
                    </div>
                    <div class="field">
                        <label for="pwd">
                            Password:<br>
                            <input type="password" name="password" id="pwd" required>
                            <br>
                        </label>
                    </div>
                    <div>
                        <button class="field-button">Login</button>
                    </div>
                </form
                <br><br>
                <form action="../accounts/index.php?action=register" method="post">
                    <p>If you do not yet have an account, please click the button below to register.</p>
                    <input type="submit" value="Create Account" />
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
