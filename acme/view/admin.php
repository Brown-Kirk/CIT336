<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $pageTitle="Acme - Account"; 
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; 
            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
            }
            $clientLevel = $_SESSION['clientData']['clientLevel'];
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
                <?php
                    if (isset($message)) {
                        echo "<br> $message <br>";
                        unset ($_SESSION['message']);
                    }
                ?>
            </section>
            <section id='accountInfo'>
                <h1>Account Management</h1>
                You are logged in<br>
                
                <br>
                <a href='../accounts/index.php?action=client-update'>Update Account Information</a>
                <br>
            </section>
            <section id='productManagement'>
                <?php
                    if ($clientLevel > 1){
                    echo " 
                            <h1>Product Management</h1>
                            Click the link below to administer products in the Acme system.<br><br>
                            <a id='productUpdateLink' href='/acme/products/index.php?action=prod-mgmt'>Product Management</a>
                        ";
                    }
                ?>
                <br>
            </section>
            <section id='reviewInfo'>
                <h1>Manage Your Product Reviews</h1>
                <?php 
                    $reviews = getReviewbyClient($_SESSION['clientData']['clientId']);
                    foreach ($reviews as $review) {
                        $reviewTime = strftime("%d %B, %Y ", strtotime($review ['reviewDate']));
                        $reviewProduct = $review['invName'];
                        echo "<div><p>$reviewProduct (Reviewed on $reviewTime) ";
                        echo "<a href='/acme/reviews?action=editReview&id=$review[reviewId]' title='Click to Edit'>Edit</a> ";
                        echo " <a href='/acme/reviews?action=deleteReview&id=$review[reviewId]' title='Click to Delete'>Delete</a></p>";
                    }
                    echo "<br>"
                ?>
                
            </section>
        </main>
        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>

