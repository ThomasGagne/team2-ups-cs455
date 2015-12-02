<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

require "generalFunctions.php";
?>
<!DOCTYPE html>
<html>
    <?php include("head.html"); ?>
    <body>

        <?php include("header.php"); ?>
        <?php include("noscript.html"); ?>

        <div class="content-center" style="margin-top: 10%;">

            <b><p class="NOISEFACTION"><span style="color: brown;">Noise</span><span style="color: dimgrey;">Faction</span></p></b>
            <table style="margin-left: auto; margin-right: auto; margin-bottom: 5px;">
                <tr>
                    <form action="/searchSongs.php">
                        <td><input type="text" name="searchSongs" class="frontpageSearch" placeholder="Search Songs" size="30"/></td>
                        <td><input type="submit" style="font-size: 16px;" value="Search Songs"></td>
                    </form>
                </tr>
            

                <tr>
                    <form class="frontpageSearch" action="/searchPlaylists.php">
                        <td><input type="text" name="searchPlaylists" class="frontpageSearch" placeholder="Search Playlists" size="30"/></td>
                        <td><input type="submit" style="font-size: 16px;" value="Search Playlists"></td>
                    </form>
                </tr>
            </table>

            <a style="text-align: center; display: block; margin: 0px auto; font-size: 14pt; color: #565656;" href="/searchHelp.php">Search Help</a>
            
            <hr>

            <table style="margin-left: auto; margin-right: auto;">
                <tr>
                    <td><a href="/login.php" style="font-size: 16pt; color: #565656;">Login</a></td>
                    <td><div style="width: 20px;"/></td>
                    <td><a href="/register.php" style="font-size: 16pt; color: #565656;">Register</a></td>
                </tr>
            </table>
        </div>
        
    </body>
</html>
