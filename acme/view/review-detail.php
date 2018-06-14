<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $pageTitle="Acme - Product Review Detail"; 
            include  $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/head.php'; 
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
            <section id="message">
                <?php 
                    if(isset($message)){ 
                        echo $message; 
                    }
                ?>
            </section>
                <?php
                    if (isset($_SESSION['loggedin'])) {
                        echo "<section id='review-list' style='background: #ffff99'>";
                        echo "<h2>Your product reviews</h2>";
                        $clientId = $_SESSION['clientData']['clientId'];
                        $reviews = getReviewByClient($clientId);
                        foreach ($reviews as $review) {
                            $productName = $review['invName'];
                            if ($review['invId'] == $prodId) {
                                $reviweTime = strftime("%d %B, %Y ", strtotime($review ['reviewDate']));
                                echo "<p>$firstname $lastname reviewed $productName on $reviewTime:</p>";
                                echo $review['reviewText']; 
                            } else {
                                echo "<p>Please <a href='/acme/accounts/index.php?action=login'>login to see your reviews.</a></p>";
                            }
                        }
                    }
                ?>
            </section>
        </main>
        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>
