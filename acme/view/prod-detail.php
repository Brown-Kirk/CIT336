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
                <?php 
                    if(isset($message)){ 
                        echo $message;
                    }
                    if(isset($prodDetail)){ 
                        echo $prodDetail; 
                    } 
                    if(isset($thumbnails)){ 
                        echo $thumbnails; 
                    }
                ?>
            </section>
            <section id='createReview'>
                <h2>Customer Reviews</h2>
                <?php
                    
                    if (isset($_SESSION['loggedin'])) {
                        $firstname = $_SESSION['clientData']['clientFirstname'];
                        $lastname = $_SESSION['clientData']['clientLastname'];
                        $clientId = $_SESSION['clientData']['clientId'];
                        $prodId = $product['invId'];
                        $screenName = substr($firstname,0,1);
                        $screenName .= $lastname;
                        echo "<form action='/acme/reviews/index.php' method='post'>";
                        echo "<p>Screen name: $screenName</p>";
                        echo "<label for=“reviewText”>Write your review:</label><br>";
                        echo "<textarea name='reviewText' id='reviewText'  rows='10' cols='60' required>";
                        if (isset($reviewText)) {
                            echo "$reviewText";
                        }
                        echo "</textarea><br>";
                        echo "<input type='submit' name='submit' value='Add Review'>";
                        echo "<input type='hidden' name='action' value='addReview'>";
                        echo "<input type='hidden' name='clientId' value='$clientId'>";
                        echo "<input type='hidden' name='invId' value='$prodId'></form>";
                    } else {
                        echo "<p>Please <a href='/acme/accounts/index.php?action=login'>login</a> to write a review.</p>";
                    }
                ?>
            </section>
            <!--display previous written reviews here-->    
            <?php 
                if (isset($_SESSION['loggedin'])) {
                    $clientId = $_SESSION['clientData']['clientId'];
                    $reviews = getReviewByClient($clientId);
                    if( $reviews == NULL ) {
                        // Do nothing
                    } else {
                        echo "<section id='review-table'>";
                        echo "<h2> Your product reviews </h2>";
                        foreach ($reviews as $review) {
                            $reviewDate = strftime("%d %B, %Y ", strtotime($review ['reviewDate']));
                            if ($review['invId'] == $prodId) {
                                echo "<p><p>$screenName wrote on $reviewDate:</p>";
                                echo $review['reviewText']; 
                                echo "<br><br>";
                            } else {
                                //Do nothing
                            }
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
