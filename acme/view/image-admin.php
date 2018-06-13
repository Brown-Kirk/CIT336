<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $pageTitle="Image Management"; 
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; 
            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
            }
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
                <h1>Image Management</h1>
                <p>
                    Welcome to our Image Management page! This page allows you to upload new pictures 
                    of our products so our visitors can see our products in real world settings. To 
                    uploaded a picture, choose the associated product from the drop down box, then 
                    click the "Choose File" button to select an image from your computer. Once selected,
                    click the "Upload" button to send us your photo! If you wish to delete an exiting 
                    image, scroll down to the image and click the "Delete" link with the filename 
                    associated to it.
                </p>
                <h2>Add New Product Image</h2>
                <?php
                    if (isset($message)) {
                        echo $message;
                    }
                ?>
                <form action="/acme/uploads/" method="post" enctype="multipart/form-data">
                    <label for="invItem">Product</label><br>
                    <?php echo $prodSelect; ?><br><br>
                    <label>Upload Image:</label><br>
                    <input type="file" name="file1"><br>
                    <input type="submit" class="regbtn" value="Upload">
                    <input type="hidden" name="action" value="upload">
                </form>
                <hr>
                <h2>Existing Images</h2>
                <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
                <?php
                    if (isset($imageDisplay)) {
                        echo $imageDisplay;
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

