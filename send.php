<?php
session_start();

if (!isset($_POST['captcha_input']) ||
    strtoupper($_POST['captcha_input']) !== $_SESSION['captcha']) {
    $sent = isset($_POST['captcha_input']) ? strtoupper($_POST['captcha_input']) : '';
    $generated = isset($_SESSION['captcha']) ? $_SESSION['captcha'] : '';
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid CAPTCHA',
        'sent' => $sent,
        'generated' => $generated
    ]);
    exit;
}

// Continue processing
echo json_encode([
    'status' => 'success',
    'message' => 'Message sent!'
]);
