<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            if(isset($prodInfo['invName'])){
                $pageTitle="Modify " . $prodInfo['invName'];
            } elseif(isset($invName)) {
                $pageTitle = $invName;                 
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
                        echo "Modify $prodInfo[invName] ";                        
                    } elseif(isset($invName)) {
                        echo $invName;                         
                    }
                ?>
            </h1>
            <section id="productUpdateForm">
                <form action="../products/index.php" method="post">
                    <fieldset>
                        <label for="invName">
                            Product Name:<br>
                            <input type="text" name="invName" id="invName" required <?php if(isset($invName)){ echo "value='$invName'"; } elseif(isset($prodInfo['invName'])) {echo "value='$prodInfo[invName]'"; }?>>
                            <br>
                        </label>
                        <label for="invDescription">
                            Product Description:<br>
                            <input type="text" name="invDescription" id="invDescription" required <?php if(isset($invDescription)){ echo "value='$invDescription'"; } elseif(isset($prodInfo['invDescription'])) {echo "value='$prodInfo[invDescription]'"; }?>>
                            <br>
                        </label>
                        <label for="invImage">
                            Product Image:<br>
                            <input type="text" name="invImage" id="invImage" required <?php if(isset($invImage)){ echo "value='$invImage'"; } elseif(isset($prodInfo['invImage'])) {echo "value='$prodInfo[invImage]'"; }?>>
                            <br>
                        </label>
                        <label for="invThumbnail">
                            Product Thumbnail:<br>
                            <input type="text" name="invThumbnail" id="invThumbnail" required <?php if(isset($invThumbnail)){ echo "value='$invThumbnail'"; } elseif(isset($prodInfo['invThumbnail'])) {echo "value='$prodInfo[invThumbnail]'"; }?>>
                            <br>
                        </label>
                        <label for="invPrice">
                            Product Price:<br>
                            <input type="number" step="0.01" min="0.01" name="invPrice" id="invPrice" required <?php if(isset($invPrice)){ echo "value='$invPrice'"; } elseif(isset($prodInfo['invPrice'])) {echo "value='$prodInfo[invPrice]'"; }?>>
                            <br>
                        </label>
                        <label for="invStock">
                            Product Stock:<br>
                            <input type="number" id="invStock" name="invStock" name="invStock" id="invStock" required <?php if(isset($invStock)){ echo "value='$invStock'"; } elseif(isset($prodInfo['invStock'])) {echo "value='$prodInfo[invStock]'"; }?>>
                            <br>
                        </label>
                        <label for="invSize">
                            Product Size:<br>
                            <input type="number" step="0.01" min="0.01" id="invSize" name="invSize" required <?php if(isset($invSize)){ echo "value='$invSize'"; } elseif(isset($prodInfo['invSize'])) {echo "value='$prodInfo[invSize]'"; }?>>
                            <br>
                        </label>
                        <label for="invWeight">
                            Product Weight:<br>
                            <input type="number" step="0.01" min="0.01" id="invWeight" name="invWeight" required <?php if(isset($invWeight)){ echo "value='$invWeight'"; } elseif(isset($prodInfo['invName'])) {echo "value='$prodInfo[invWeight]'"; }?>>
                            <br>
                        </label>
                        <label for="invLocation">
                            Product Location:<br>
                            <input type="text" name="invLocation" id="invLocation" required <?php if(isset($invLocation)){ echo "value='$invLocation'"; } elseif(isset($prodInfo['invLocation'])) {echo "value='$prodInfo[invLocation]'"; }?>>
                            <br>
                        </label>
                        <label for="categoryId">
                            Product Category:
                            <?php
                                echo buildCategoryListWithProdInfo($prodInfo);
                            ?>
                            <br>
                        </label>
                        <label for="invVendor">
                            Product Vendor:<br>
                            <input type="text" name="invVendor" id="invVendor" required <?php if(isset($invVendor)){ echo "value='$invVendor'"; } elseif(isset($prodInfo['invVendor'])) {echo "value='$prodInfo[invVendor]'"; }?>>
                            <br>
                        </label>
                        <label for="invStyle">
                            Product Style:<br>
                            <input type="text" name="invStyle" id="invStyle" required <?php if(isset($invStyle)){ echo "value='$invStyle'"; } elseif(isset($prodInfo['invStyle'])) {echo "value='$prodInfo[invStyle]'"; }?>>
                            <br>
                        </label>
                    <!-- Add the action name - value pair -->
                    <input type="submit" name="submit" value="Update Product">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="updateProd">
                    <input type="hidden" name="invId" value="<?php if(isset($prodInfo['invId'])){ echo $prodInfo['invId'];} elseif(isset($invId)){ echo $invId; } ?>">
                    </fieldset>
                </form>
            </section>

        </main>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>
