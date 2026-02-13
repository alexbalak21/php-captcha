<?php
session_start();

if (!isset($_POST['captcha_input']) ||
    strtoupper($_POST['captcha_input']) !== $_SESSION['captcha']) {
    die("Invalid CAPTCHA");
}

// Continue processing
echo "Message sent!";
