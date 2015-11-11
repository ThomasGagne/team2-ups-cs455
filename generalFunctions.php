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

// Returns True if an input (e.g. a textbox input) is good.
// INPUT: What is hoped to be a string.
// OUPUT: True if the argument's not an empty string.
function inputted_properly($var) {
    return !empty($var) and !($var === "");
}

?>
