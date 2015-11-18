<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION["username"]);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
