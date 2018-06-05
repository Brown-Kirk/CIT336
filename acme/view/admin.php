<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Acme - Account Login"; include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
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
            <?php
                $firstname = $_SESSION['clientData']['clientFirstname'];
                $lastname = $_SESSION['clientData']['clientLastname'];
                $emailaddress = $_SESSION['clientData']['clientEmail'];
                $level = $_SESSION['clientData']['clientLevel'];
                echo "<section id='accountInfo'>
                    <h1>$firstname $lastname</h1>
                    <ul>
                        <li>First name: $firstname</li>
                        <li>Last name: $lastname</li>
                        <li>Email: $emailaddress</li>
                        <li>Level: $level</li>
                    </ul>
                    </section>";
                if ($level == 3){
                echo '<section id="productLink"><a href="/acme/products/index.php?action=prod-mgmt">Products</a><br><br></section>';
                }
                ?>
        </main>

        <footer>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
            ?>
        </footer>
    </body>
</html>

