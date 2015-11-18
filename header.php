<header>
    <div class="header">
        <span class="headerUsername">
            <?php
            if (isset($_SESSION["username"])) {
                echo '<a href="/account/index.php?user=' . $_SESSION["username"] . '">';
                echo $_SESSION["username"] . '</a>';
            } else {
                echo '<a href="/login.php">Login</a>';
                echo "  |  ";
                echo '<a href="/register.php">Register</a>';
            }
            ?>
        </span>
    </div>
</header>
