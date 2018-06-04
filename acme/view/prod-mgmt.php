<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Acme - Product Management"; include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
    </head>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/header.php'; ?>
        <nav class="nav">
            <?php echo buildNav(); ?>
        </nav>
        <main>
            <div class="Product Management">
                <!--php code if message is set-->
                  <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <!--end php-->
                <h1>Product Management</h1>
                <p>Welcome to the product management page. Please choose an option below:
                <ul>
                    <li><a href="../products/index.php?action=new-cat" >Add a New Category</a></li>
                    <li><a href="../products/index.php?action=new-prod" >Add a New Product</a></li>
                </ul>
            </div>
        </main>

            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
            ?>
    </body>
</html>
