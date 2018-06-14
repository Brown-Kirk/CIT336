<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $pageTitle="Acme - Product Review Update"; 
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
            <section id='reviewUpdate'>
                <h1>Review Update</h1>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <form method="post" action="/acme/reviews/index.php" id="reviewform">
                    <fieldset>
                        <label for="reviewtext">Review Text</label><br>
                        <textarea name="reviewtext" id="reviewtext" form="reviewform" rows="10" cols="75" required><?php
                            if (isset($reviewText)) {
                                echo $reviewText;
                            } elseif (isset($review['reviewText'])) {
                                echo $review['reviewText'];
                            }
                            ?></textarea><br>

                        <button type="submit" name="updateReview" id="updateReview">Update Review</button>
                        <!-- Add the action key - value pair -->
                        <input type="hidden" name="action" value="updateReview">
                        <input type="hidden" name="invid" value="<?php
                        if (isset($reviewInfo['invId'])) {
                            echo $reviewInfo['invId'];
                        } elseif (isset($invId)) {
                            echo $invId;
                        }
                        ?>">
                        <input type="hidden" name="reviewid" value="<?php
                        if (isset($reviewInfo['reviewId'])) {
                            echo $reviewInfo['reviewId'];
                        } elseif (isset($reviewId)) {
                            echo $reviewId;
                        }
                        ?>">
                    </fieldset>
                </form>                    
            </section>         
        </main>
        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/acme/includes/footer.php';
        ?>
    </body>
</html>