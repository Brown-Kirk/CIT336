<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $pageTitle="Acme - Account Login"; 
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; 
        ?>
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
            <section id='message'>
                <?php
                    if (isset($message)) {
                        echo "<br> $message <br>";
                        unset ($_SESSION['message']);
                    }
                ?>
            </section>
            <section class="login">
                <form action="../accounts/index.php?action=Login" method="post">
                    <h1>Acme Login</h1>
                    <section class="field">
                        <label for="name">
                            Email Address:<br>
                            <input type="email" id="clientEmail" name="clientEmail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                            <br>
                        </label>
                    </section>
                    <section class="field">
                        <label for="pwd">
                            Password:<br>
                            <input type="password" name="clientPassword" id="clientPassword" required
                               pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                            <br><span>Passwords must be at least 8 characters and contain at least 1 number, 
                            1 capital letter, and 1 special character</span>
                        </label>
                    </section>
                    <input type="submit" name="submit" id="regbtn" value="Login">
                    <input type="hidden" name="action" value="Login">
                </form
                <br><br>
                <form action="../accounts/index.php?action=register" method="post">
                    <p>If you do not yet have an account, please click the button below to register.</p>
                    <input type="submit" value="Create Account" />
                </form>
            </section>
        </main>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>
