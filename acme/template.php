<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Welcome to Acme!"; include './includes/head.php'; ?>
    </head>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'] . './acme/includes/header.php'; ?>
        <nav>
        <?php 
            echo buildNav();
        ?>
        </nav>
        <main class="main">
            <?php include $path . '/acme/includes/main.php'; ?>
        
        
        
        </main>
        <?php include '/acme/includes/footer.php'; ?>
    </body>

</html>   