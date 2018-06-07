<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $pageTitle="Acme - New Category"; 
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; ?>
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
            <h1>Add a New Category</h1>
            <section class="field">
                <form action="../products/index.php" method="post">
                    <fieldset>
                        <label for="categoryName">
                            Category Name:<br>
                            <input type="text" id="categoryName" name="categoryName" <?php if(isset($categoryname)){echo "value='$categoryname'";} ?> required/>
                            <br>
                        </label>
                        <input type="submit" name="submit" id="btn" value="Submit"/>
                        <input type="hidden" name="action" value="add-cat"/>
                    </fieldset>
                </form>
            </section>
        </main>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>
