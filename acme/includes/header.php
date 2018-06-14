<header>
    <section id="header">
        <section id="logo">
            <a href="http://localhost/acme/"><img src="http://localhost/acme/images/site/logo.gif" alt="Acme Logo" height="80"></a>
        </section>
        <section id="account">
            <?php
                if (isset($_SESSION['loggedin'])) {
                    if(isset($_SESSION['firstname'])){
                        $firstname = $_SESSION['firstname'];
                        echo "<span><a href='/acme/accounts/index.php?action=admin'>Welcome $firstname</a><br></span>";
                        echo '<span id="logout"><a href="/acme/accounts/index.php?action=Logout">Logout</a></span>';
                    } else {
                        echo '<span><a href="http://localhost/acme/accounts/"><img src="/acme/images/site/account.gif" alt="Folder Image" height="30">
                        My Account</a><br></span>';
                        echo '<span id="logout"><a href="/acme/accounts/index.php?action=Logout">Logout</a></span>';
                    } 
                } else {
                    echo '<span><a href="/acme/accounts/index.php?action=login" title="Login or Register"><img src="/acme/images/site/account.gif" alt="Folder Image" height="30">
                        My Account</a><br></span>';
                }
            ?>
        </section>
    </section>
</header>
