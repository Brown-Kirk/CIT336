<header>
    <div id="header">
        <div id="logo">
            <a href="http://localhost/acme/"><img src="http://localhost/acme/images/site/logo.gif" alt="Acme Logo" height="80"></a>
        </div>
        <div id="account">
            <?php
                if (isset($_SESSION['loggedin'])) {
                    echo '<div id="logout"><a href="/acme/accounts/index.php?action=Logout">Logout</a></div>';
                } else {
                    echo '<a href="http://localhost/acme/accounts/"><img src="/acme/images/site/account.gif" alt="Folder Image" height="30">
                        My Account</a>';
                }
            ?>
            
        </div>
    </div>
</header>
