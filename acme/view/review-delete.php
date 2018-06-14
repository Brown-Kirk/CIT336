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
                <h1 class="login"><?php if(isset($invReviewNameInfo['invName'])){ echo "Delete ". $invReviewNameInfo['invName'] . "Review";} ?></h1>
                <p>Confirm Review Deletion. The delete is permanent.</p>

                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <form method="post" action="/acme/reviews/index.php">
                    <fieldset>
                        <label for="reviewtext">Review Text</label><br>
                        <textarea name="reviewtext" id="reviewtext" rows="10" cols="75" required readonly>
                            <?php
                            if (isset($reviewText)) {
                                echo $reviewText;
                            } elseif (isset($review['reviewText'])) {
                                echo $review['reviewText'];
                            }
                            ?></textarea><br>

                        <button type="submit" name="delete" id="delete" >Delete Review</button>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="reviewId" value="<?php
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