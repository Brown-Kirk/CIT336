<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $pageTitle="Welcome to Acme!"; include $_SERVER['DOCUMENT_ROOT'] . './acme/includes/head.php'; ?>
    </head>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'] . './acme/includes/header.php'; ?>
        <nav>
        <?php echo buildNav() ?>
        </nav>
        <main class="main">
            <?php include $_SERVER['DOCUMENT_ROOT'] . './acme/includes/main.php'; ?>
            <aside class="featured">
                <section id="featuredproduct">
                    <section id="productdetails">
                        <h2 id="producttitle"><br>Acme Rocket</h2>
                        <p id="productfeatures">Quick lighting fuse<br>
                            NHTSA approved seat belts<br>
                            Mobile launch stand included</p>
                        <a href="./home.php"><img src="./images/site/iwantit.gif" alt="I want it now!"></a>
                        <br><br><br>
                    </section>
                </section>
            </aside>
            <section id="reviews">
                <h3>Acme Rocket Reviews</h3>
                <ul>
                    <li>"I don't know how I ever caught roadrunners before this." (4/5)</li>
                    <li>"That thing was fast!" (4/5)</li>
                    <li>"Talk about fast delivery." (5/5)</li>
                    <li>"I didn't even have to pull the meat apart." (4.5/5)</li>
                    <li>"I'm on my thirieth one. I love these things!" (5/5</li>
                </ul>
            </section>
            <section id="featuredrecipes">
                <h3>Featured Recipes</h3>
                <section class="recipecontainer">
                    <section class="imagecontainer">
                        <img src="/acme/images/recipes/bbqsand.jpg" alt="Pulled Roadrunner BBQ" class="recipeimage">
                    </section>
                    <a href="./" title="Pulled Roadrunner BBQ"><span class="caption">Pulled Roadrunner BBQ</span></a>
                </section>
                <section class="recipecontainer">
                    <section class="imagecontainer">
                        <img src="/acme/images/recipes/potpie.jpg" alt="Roadrunner Pot Pie" class="recipeimage">
                    </section>
                    <a href="./" title="Roadrunner Pot Pie"><span class="caption">Roadrunner Pot Pie</span></a>
                </section>
                <section class="recipecontainer">
                    <section class="imagecontainer">
                        <img src="/acme/images/recipes/soup.jpg" alt="Roadrunner Soup" class="recipeimage">
                    </section>
                    <a href="./" title="Roadrunner Soup"><span class="caption">Roadrunner Soup</span></a>
                </section>
                <section class="recipecontainer">
                    <section class="imagecontainer">
                        <img src="/acme/images/recipes/taco.jpg" alt="Roadrunner Tacos" class="recipeimage">
                    </section>
                    <a href="./" title="Roadrunner Tacos"><span class="caption">Roadrunner Tacos</span></a>
                </section>
            </section>
        </main>
        <?php include $_SERVER['DOCUMENT_ROOT'] . './acme/includes/footer.php'; ?>
    </body>

</html>            