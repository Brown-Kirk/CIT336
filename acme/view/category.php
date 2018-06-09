<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Products | Acme, Inc."; include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
    </head>
    <body>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/header.php';
            ?>
        <nav class="nav">
            <?php echo buildNav() ?>
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
            <section id="prodHeader">
                <h1><?php echo $category; ?> Products</h1>
            </section>
            <section id='prod-display'>            
                <?php if(isset($prodDisplay)){ echo $prodDisplay; } ?>
            </section>
        </main>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
            ?>
    </body>
</html>
