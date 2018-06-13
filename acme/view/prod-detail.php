<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            if(isset($product['invName'])){
                $pageTitle= $product['invName'];
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
            <section id="productDetail">
                <?php if(isset($message)){ echo $message; } ?>
                <?php if(isset($prodDetail)){ echo $prodDetail; } ?>
                <?php if(isset($thumbnails)){ echo $thumbnails; } ?>
            </section>
        </main>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>
