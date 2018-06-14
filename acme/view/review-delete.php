<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $pageTitle="Acme - Product Review Delete"; 
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
            <section id='message'>
                <?php
                    if (isset($message)) {
                        echo "<br> $message <br>";
                        unset ($_SESSION['message']);
                    }
                ?>
            </section>
            <section>
                <?php
                    echo "<h1 class='login'>";
                    if(isset($invReviewNameInfo['invName'])){ 
                        echo "Delete ". $invReviewNameInfo['invName'] . "Review</h1>";
                        echo "<p>Confirm Review Deletion. The delete is permanent.</p>";
                    }
                    if (isset($message)) {
                        echo $message;
                    }
                    echo "<form method='post' action='/acme/reviews/index.php'><fieldset>";
                    echo "<label for='reviewtext'>Review Text</label><br>";
                    echo "<textarea name='reviewtext' id='reviewtext' rows='10' cols='75' required readonly>";
                        if (isset($reviewText)) {
                            echo $reviewText;
                        } elseif (isset($review['reviewText'])) {
                            echo $review['reviewText'];
                        }
                    echo "</textarea><br>";
                    echo "<button type='submit' name='delete' id='delete' >Delete Review</button>";
                    echo "<input type='hidden' name='action' value='delete'>";
                    echo "<input type='hidden' name='reviewId' value='";
                    if (isset($reviewInfo['reviewId'])) {
                        echo $reviewInfo['reviewId'];
                    } elseif (isset($reviewId)) {
                        echo $reviewId;
                    }
                    echo "'></fieldset></form>";
                ?>  
            </section>
        </main>
        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>