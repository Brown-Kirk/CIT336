<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Acme - New Product"; include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
    </head>
    <body>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/header.php';
            ?>
        <nav class="nav">
            <?php echo $navList; ?>
        </nav>
        <main>
            <form action="../products/index.php" method="post">
                <div class="error">
                    <!--php code if message is set-->
                    <?php
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <!--end php-->
                </div>
                <h1>Add a New Product</h1>
                <div class="field">
                    <label for="invName">
                        Product Name:<br>
                        <input type="text" id="invName" name="invName">
                        <br>
                    </label>
                    <label for="invDescription">
                        Product Description:<br>
                        <input type="text" id="invDescription" name="invDescription">
                        <br>
                    </label>
                    <label for="invImage">
                        Product Image:<br>
                        <input type="text" id="invImage" name="invImage" value="/acme/images/no-image.gif">
                        <br>
                    </label>
                    <label for="invThumbnail">
                        Product Thumbnail:<br>
                        <input type="text" id="invThumbnail" name="invThumbnail"  value="/acme/images/no-image.gif">
                        <br>
                    </label>
                    <label for="invPrice">
                        Product Price:<br>
                        <input type="text" id="invPrice" name="invPrice">
                        <br>
                    </label>
                    <label for="invStock">
                        Product Stock??:<br>
                        <input type="text" id="invStock" name="invStock">
                        <br>
                    </label>
                    <label for="invSize">
                        Product Size:<br>
                        <input type="text" id="invSize" name="invSize">
                        <br>
                    </label>
                    <label for="invWeight">
                        Product Weight:<br>
                        <input type="text" id="invWeight" name="invWeight">
                        <br>
                    </label>
                    <label for="invLocation">
                        Product Location:<br>
                        <input type="text" id="invLocation" name="invLocation">
                        <br>
                    </label>
                    <label for="categoryId">
                        Product Category:
                        <?php echo $catList; ?>
                        <br>
                    </label>
                    <label for="invVendor">
                        Product Vendor:<br>
                        <input type="text" id="invVendor" name="invVendor">
                        <br>
                    </label>
                    <label for="invStyle">
                        Product Style:<br>
                        <input type="text" id="invStyle" name="invStyle">
                        <br>
                    </label>
                </div>
                <div>
                    <!-- Add the action name - value pair -->
                    <input type="submit" name="submit" id="btn" value="Submit">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="add-prod">
                </div>
            </form>
        </main>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
            ?>
    </body>
</html>
