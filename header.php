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
            |
        </span>
        <span>
            <form class="headerSearchContainer" action="/searchSongs.php">
                <input type="text" name="searchSongs" class="headerSearch" placeholder="Search Songs" size="30"/>
                <input type="submit" style="font-size: 12px;" value="Search Songs">
            </form>
        </span>
        <span>
            <form class="headerSearchContainer" action="/searchPlaylists.php">
                <input type="text" name="searchPlaylists" class="headerSearch" placeholder="Search Playlists" size="30"/>
                <input type="submit" style="font-size: 12px;" value="Search Playlists">
            </form>
        </span>
        <span class="headerUsername">
            <a href="/searchHelp.php" style="font-size: 14px; margin-left: -10px;">Search Help</a>
        </span>
        <!-- uploadFile.php -->
        <span class="headerLogout">
            <?php
            if (isset($_SESSION["username"])) {
                echo '<a href="/newPlaylist.php">New Playlist</a>';
                echo "  |  ";
                echo '<a href="/uploadFile.php">Upload</a>';
                echo "  |  ";
                echo '<a href="/logout.php">Logout</a>';
            }
            ?>
        </span>
    </div>
</header>
