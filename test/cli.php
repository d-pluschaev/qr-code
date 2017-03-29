<?php

/**
 * Script for testing QrCode functionality (Console)
 */

if (PHP_SAPI != "cli") {
    die("This is a console script");
}

// PSR-4 autoloader used for emulating namespace resolving like in any modern framework
require_once 'support/sample_psr4_autoloader.php';

// Functionality test

use DPluschaev\QrCode\QrCode;
use DPluschaev\QrCode\Renderer\GoogleChartsRenderer;

$qrCode = new QrCode("Test", 100, 100);
$qrCode->setRenderer(new GoogleChartsRenderer());
try {
    $content = $qrCode->generate();
    echo "Returned content length: " . strlen($content)
        . " (" . (substr($content, 1, 3) == "PNG" ? "PNG" : "NOT PNG") . ")\n";
} catch (Exception $e) {
    echo "Cannot render QR code: " . $e->getMessage() . "\n";
}
