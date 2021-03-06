<header>
    <div class="header">
        <!-- Display Username or login -->
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
            |
        </span>
        <span>
            <!-- Search Songs -->
            <form class="headerSearchContainer" action="/searchSongs.php">
                <input type="text" name="searchSongs" class="headerSearch" placeholder="Search Songs" size="30"/>
		<input type="text" name="offset" value="0" hidden="true">
                <input type="submit" style="font-size: 12px;" value="Search Songs">
            </form>
        </span>
        <!-- Search Playlists -->
        <span>
            <form class="headerSearchContainer" action="/searchPlaylists.php">
                <input type="text" name="searchPlaylists" class="headerSearch" placeholder="Search Playlists" size="30"/>
		<input type="text" name="offset" value="0" hidden="true">
                <input type="submit" style="font-size: 12px;" value="Search Playlists">
            </form>
        </span>
        <span class="headerUsername">
            <a href="/searchHelp.php" style="font-size: 14px; margin-left: -10px;">Search Help</a>
        </span>
        <!-- Home button -->
        <!-- Logout button -->
        <span class="headerLogout">
            <?php
            if (isset($_SESSION["username"])) {
                echo '<a href="/uploadPage.php">Upload Song</a>';
                echo "  |   ";
                echo '<a href="/newPlaylist.php">Create Playlist</a>';
                echo "  |   ";
                echo '<a href="/logout.php">Logout</a>';
		echo "   |   ";
            }
            ?>
            <a href="/index.php">Home</a>
        </span>

    </div>
</header>
