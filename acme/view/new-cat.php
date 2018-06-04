<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Acme - New Category"; include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
    </head>
    <body>
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/header.php';
            ?>
        <nav class="nav">
            <?php echo buildNav() ?>
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
                <h1>Add a New Category</h1>
                <div class="field">
                    <label for="categoryName">
                        Category Name:<br>
                        <input type="text" id="categoryName" name="categoryName" <?php if(isset($categoryname)){echo "value='$categoryname'";} ?> required>
                        <br>
                    </label>
                </div>
                <div>
                    <!-- Add the action name - value pair -->
                    <input type="submit" name="submit" id="btn" value="Submit">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="add-cat">
                </div>
            </form>
        </main>

            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
            ?>
    </body>
</html>
