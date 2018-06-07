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
            <section id='addNewProduct'>
                <h1>Add a New Product</h1>
                <form action="../products/index.php" method="post">
                    <fieldset>
                        <label for="invName">
                            Product Name:<br>
                            <input type='text' name='invName' <?php if(isset($invName)){echo "value='$invName'";} ?> required>
                            <br>
                        </label>
                        <label for="invDescription">
                            Product Description:<br>
                            <input type="text" id="invDescription" name="invDescription" <?php if(isset($invDescription)){echo "value='$invDescription'";} ?> required>
                            <br>
                        </label>
                        <label for="invImage">
                            Product Image:<br>
                            <input type="text" id="invImage" name="invImage"  <?php if(isset($invImage)){echo "value='$invImage'";} else {echo "value='/acme/images/no-image.gif'";} ?> required>
                            <br>
                        </label>
                        <label for="invThumbnail">
                            Product Thumbnail:<br>
                            <input type="text" id="invThumbnail" name="invThumbnail"  <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} else {echo "value='/acme/images/no-image.gif'";} ?> required >
                            <br>
                        </label>
                        <label for="invPrice">
                            Product Price:<br>
                            <input type="number" step="0.01" min="0.01" id="invPrice" name="invPrice" <?php if(isset($invPrice)){echo "value='$invPrice'";} ?> required >
                            <br>
                        </label>
                        <label for="invStock">
                            Product Stock??:<br>
                            <input type="number" id="invStock" name="invStock" <?php if(isset($invStock)){echo "value='$invStock'";} ?> required >
                            <br>
                        </label>
                        <label for="invSize">
                            Product Size:<br>
                            <input type="number" step="0.01" min="0.01" id="invSize" name="invSize" <?php if(isset($invSize)){echo "value='$invSize'";} ?> required >
                            <br>
                        </label>
                        <label for="invWeight">
                            Product Weight:<br>
                            <input type="number" step="0.01" min="0.01" id="invWeight" name="invWeight" <?php if(isset($invWeight)){echo "value='$invWeight'";} ?> required >
                            <br>
                        </label>
                        <label for="invLocation">
                            Product Location:<br>
                            <input type="text" id="invLocation" name="invLocation" <?php if(isset($invLocation)){echo "value='$invLocation'";} ?> required >
                            <br>
                        </label>
                        <label for="categoryId">
                            Product Category:
                            <?php echo buildCategoryList(); ?>
                            <br>
                        </label>
                        <label for="invVendor">
                            Product Vendor:<br>
                            <input type="text" id="invVendor" name="invVendor" <?php if(isset($invVendor)){echo "value='$invVendor'";} ?> required >
                            <br>
                        </label>
                        <label for="invStyle">
                            Product Style:<br>
                            <input type="text" id="invStyle" name="invStyle" <?php if(isset($invStyle)){echo "value='$invStyle'";} ?> required >
                            <br>
                        </label>

                        <input type="submit" name="submit" id="btn" value="Submit">
                        <input type="hidden" name="action" value="add-prod">
                    </fieldset>
                </form>
            </section>
        </main>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
            ?>
    </body>
</html>
