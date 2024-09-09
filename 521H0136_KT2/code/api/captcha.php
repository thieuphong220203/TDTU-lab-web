<?php
session_start();
function generateCaptcha($length = 6)
{
    $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $captcha = "";
    $charsLength = strlen($chars);

    // Generate random characters
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $charsLength - 1);
        $captcha .= $chars[$randomIndex];
    }

    return $captcha;
}

$captcha = generateCaptcha(); // Implement your function to generate CAPTCHA text
$_SESSION['captcha_code'] = $captcha;

echo $captcha;
