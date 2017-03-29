<?php

/**
 * Script for testing QrCode functionality (Web Server)
 */

if (PHP_SAPI == "cli") {
    die("This is a web server script");
}

// PSR-4 autoloader used for emulating namespace resolving like in any modern framework
require_once '../support/sample_psr4_autoloader.php';

// Functionality test

// process POST
$postData = [
    'dataString',
    'width',
    'height',
];

$collectedPostData = [];
foreach ($postData as $key) {
    if (!empty($_POST[$key])) {
        $collectedPostData[$key] = $_POST[$key];
    }
}

use DPluschaev\QrCode\QrCode;
use \DPluschaev\QrCode\Renderer\GoogleChartsRenderer;

if (!empty($collectedPostData)) {
    $qrCode = new QrCode();

    foreach ($collectedPostData as $key => $value) {
        $qrCode->$key = $value;
    }

    $qrCode->setRenderer(new GoogleChartsRenderer());
    try {
        $content = $qrCode->generate();

        if ($content) {
            header("Content-Type: image/png");
            echo $content;
            exit;
        } else {
            echo "Empty content returned";
        }
    } catch (Exception $e) {
        echo "Cannot render QR code: " . $e->getMessage() . "\n";
    }
}
