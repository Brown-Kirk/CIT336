<header>
    <section id="header">
        <section id="logo">
            <a href="http://localhost/acme/"><img src="http://localhost/acme/images/site/logo.gif" alt="Acme Logo" height="80"></a>
        </section>
        <section id="account">
            <?php
                // Check for logged in session variable
                if (isset($_SESSION['loggedin'])) {
                    // Check for firstname session variable
                    if(isset($_SESSION['firstname'])){
                        // Declare firstname variable
                        $firstname = $_SESSION['firstname'];
                        // Personalized header linked to admin page
                        echo "<span><a href='/acme/accounts/index.php?action=admin'>Welcome $firstname</a><br></span>";
                        // Provide logout link
                        echo '<span id="logout"><a href="/acme/accounts/index.php?action=Logout">Logout</a></span>';
                    } else {
                        // Non-personalized header link to accounts page
                        echo '<span><a href="http://localhost/acme/accounts/"><img src="/acme/images/site/account.gif" alt="Folder Image" height="30">
                        My Account</a><br></span>';
                        // Link to logout
                        echo '<span id="logout"><a href="/acme/accounts/index.php?action=Logout">Logout</a></span>';
                    } 
                } else {
                    // My account link to login page
                    echo '<span><a href="/acme/accounts/index.php?action=login" title="Login or Register"><img src="/acme/images/site/account.gif" alt="Folder Image" height="30">
                        My Account</a><br></span>';
                }
            ?>
        </section>
    </section>
</header>
