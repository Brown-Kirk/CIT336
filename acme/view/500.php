<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $path = $_SERVER['DOCUMENT_ROOT'];
            $pageTitle="Acme, Inc."; 
            include $path . '/acme/includes/head.php'; 
        ?>
    </head>
    <body>
        <?php 
            include $path . '/acme/includes/header.php';
            include $path . '/acme/includes/nav.php'; 
        ?>
        <main class="main">
            <?php include $path . '/acme/includes/main.php'; ?>
            <h1>Server Error</h1>
            <p>The server experienced a problem</p>
        
        
        </main>
        <?php include $path . '/acme/includes/footer.php'; ?>
    </body>
</html>            