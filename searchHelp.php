<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

require "generalFunctions.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Team2</title>
        <link rel="stylesheet" type="text/css" href="css/basic.css">
    </head>
    <body>

        <?php include("header.php"); ?>
        <?php include("noscript.html"); ?>

        <div class="content">
            <h2>Searching</h2>
            <ul>
                <li><h3>Basics</h3></li>
                <ul>
                    <li class="searchExample">panda</li>
                    Search for any songs or playlists with the word "panda" in the title. Case is ignored in all search terms, including tags, artists, users, etc.
                    <li class="searchExample">green martian </li>
                    Search for any songs or playlists with the words "green" and "martian" in the title.
                    <li class="searchExample">retro -earthling</li>
                    Search for any songs or playlists which contain the word "retro" and do not contain the word "earthling" in the title.
                    <!-- Not sure if this will be implemented -->
                    <!-- <li class="searchExample">~red ~blue</li> -->
                    <!-- Search for any songs or playlists which contain either the word "red" or the word "blue" in the title. May not work well with other tags. -->
                </ul>
                <li><h3>Tags</h3></li>
                <ul>
                    <li class="searchExample">tag:rock tag:pop</li>
                    Search for any songs or playlists which have the tags "rock" and "pop".
                    <li class="searchExample">tag:metal -tag:rap</li>
                    Search for any songs or playlists which have the tag "metal" and do not have the tag "rap".
                    <li class="searchExample">tag:post_rock</li>
                    Tags which contain multiple words will use underscores rather than spaces. This searches for all songs and playlists with the tag "post_rock".
                    <li class="searchExample">tag:future_bass -tag:punk universe -comp</li>
                    Search for any songs and playlists which have the tag "future_bass", do not have the tag "punk", have the word "universe" in the title, and do not have the word "comp" in the title.
                </ul>
                <li><h3>Artists and Users</h3></li>
                <ul>
                    <li class="searchExample">artist:frank</li>
                    Search for any songs or playlists containing songs made by the artist "frank".
                    <li class="searchExample">artist:bob_dylan</li>
                    Search for any songs or playlists containing songs made by the artist "bob dylan".
                    <li class="searchExample">user:retro93</li>
                    Search for any songs or playlists containing songs uploaded by the user "retro93".
                    <li class="searchExample">artist:benn_jordan -user:punkLov3r</li>
                    Search for any songs or playlists containing songs made bythe artist "benn jordan" and not uploaded by the user "punkLov3r".
                </ul>
                <li><h3>Sorting Results</h3></li>
                <ul>
                    <li class="searchExample">order:score</li>
                    Search for all songs or playlists appearing in order from most-highly rated to least-highly rated.
                    <li class="searchExample">tag:hiphop order:score</li>
                    Search for all songs or playlists with the tag "hiphop" in order from most-highly rated to least-highly rated.
                    <li class="searchExample">order:score_asc</li>
                    Search for all songs or playlists in order from least-highly rated to most-highly rated.
                </ul>
            </ul>
        </div>
        
    </body>
</html>
