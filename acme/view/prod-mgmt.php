<!DOCTYPE html>
<html lang="en">
    <?php
        if ($_SESSION['clientData']['clientLevel'] <2) {
            header('location:/acme/');
            exit;
        }
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
        }
    ?>
    <head>
        <?php 
            $pageTitle="Acme - Product Management"; 
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; 
        ?>
    </head>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/header.php'; ?>
        <nav class="nav">
            <?php echo buildNav(); ?>
        </nav>
        <main>
            <section class="Product Management">
            <h1>Product Management</h1>
            <p>Welcome to the product management page. Please choose an option below:
            <ul>
                <li><a href="../products/index.php?action=new-cat" >Add a New Category</a></li>
                <li><a href="../products/index.php?action=new-prod" >Add a New Product</a></li>
            </ul>
            </section>
            <section id='message'>
                <?php
                    if (isset($message)) {
                        echo "<br> $message <br>";
                        unset ($_SESSION['message']);
                    } else {
                        echo $prodList;
                    }
                ?>
            </section>
        </main>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>
<?php unset($_SESSION['message']); ?>
