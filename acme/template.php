<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $pageTitle="Acme"; 
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; 
            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
            }
            $clientLevel = $_SESSION['clientData']['clientLevel'];
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

        </main>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>

