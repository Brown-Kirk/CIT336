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
            <?php echo buildNav(); ?>
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
                            Email Address:<br>
                            <input type="email" id="name" name="username" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                            <br>
                        </label>
                    </div>
                    <div class="field">
                        <label for="pwd">
                            Password:<br>
                            <input type="password" name="password" id="pwd" required
                               pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                            <br><span>Passwords must be at least 8 characters and contain at least 1 number, 
                            1 capital letter, and 1 special character</span>
                        </label>
                    </div>
                    <input type="submit" name="submit" id="regbtn" value="Login">
                    <input type="hidden" name="action" value="Login">
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
