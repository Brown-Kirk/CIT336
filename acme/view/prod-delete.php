<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            if(isset($prodInfo['invName'])){
                $pageTitle="Delete " . $prodInfo['invName'];
            } else {
                $pageTitle = "Acme, Inc.";                 
            }
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; 
        ?>    
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
            <h1>
                <?php 
                    if(isset($prodInfo['invName'])){
                        echo "Delete $prodInfo[invName]";
                    } 
                ?>
            </h1>
            
            <section class="error">
                <!--php code if message is set-->
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <!--end php-->
            </section>
            <form action="../products/index.php" method="post">
                <fieldset>
                    <label for="invName">
                        Product Name:<br>
                        <input type="text" name="invName" id="invName" required  readonly <?php if(isset($prodInfo['invName'])) {echo "value='$prodInfo[invName]'"; }?>>
                        <br>
                    </label>
                    <label for="invDescription">
                        Product Description:<br>
                        <input type="text" name="invDescription" id="invDescription" required readonly <?php if(isset($prodInfo['invDescription'])) {echo "value='$prodInfo[invDescription]'"; }?>>
                        <br>
                    </label>
                </fieldset>
                <input type="submit" name="submit" value="Delete Product">
                <input type="hidden" name="action" value="deleteProd">
                <input type="hidden" name="invId" value="<?php if(isset($prodInfo['invId'])){ echo $prodInfo['invId'];} ?>">
            </form>
        </main>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>
