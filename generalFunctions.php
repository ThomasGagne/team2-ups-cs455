<?php
// This is a file where we'll put PHP functions that we'll be using in most pages,
// to avoid code repetition.

// Please put a 1-line description of what your function does in here
// and include a description of what it takes as an argument and what it returns.


// Cleans up an inputted string value of extra spaces, backslashes, and sql injections.
// INPUT: A string to be cleaned.
// OUTPUT: The inputted string minus any unnecessary or dangerous characters/expressions.
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Returns True if an input (e.g. a textbox input) is a non-empty string.
// INPUT: What is hoped to be a string.
// OUPUT: True if the argument's not an empty string.
function inputted_properly($var) {
    return !empty($var) and !($var === "");
}

// Return a string which can be echoed to the page and embodies a music player
// INPUT: A dictionary of all the song's details. The keys should at a minimum be:
// title
// artist
// uploader
// location (as a URL)
// score (number of stars)
// OUTPUT: An HTML string which embodies the music player
function generateSongPlayer($songArr) {
    $title = $songArr["title"];
    $artist = $songArr["artist"];
    $uploader = $songArr["uploader"];
    $location = $songArr["location"];
    $score = $songArr["score"];

    $html = "<div class='songPlayer'><table><tr><td>";

    // Add the score
    $html = $html . "<span class='score'>⬆<b>$score</b></span>";

    // Add the star button
    if (inputted_properly($_SESSION["username"])) {
        $starID = $title . ":" . $artist . ":" . $uploader . ":star";
        $username = $_SESSION["username"];
        $html = $html . "<button class='playerButton' id='$starID' onClick='starSong(\"$username\", \"$title\", \"$artist\", \"$uploader\");'>&#9733;</button>";
    } else {
        $html = $html . "<button class='playerButton' disabled='true'>&#9733;</button>";
    }

    // Add the play button
    $playID = "" . $title . ":" . $artist . ":" . $uploader . ":play";
    $html = $html . "<button id='$playID' onClick='playPauseSong(\"$playID\", \"$location\");' class='playerButton'>▶</button>";

    // Add the song details and time counter
    $html = $html . "<table class='songDetailsTable'><tr><td>$title - $artist</td></tr>";
    $timerID = $title . ":" . $artist . ":" . $uploader . ":time";
    $html = $html . "<tr><td><span id='$timerID'>00:00</span></td></tr>";

    // Clean up
    $html = $html . "</table></td></tr></table></div>";

    return $html;
}

?>
