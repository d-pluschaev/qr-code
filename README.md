
Self-contained solution. No dependencies used, can be added to any 
framework as an external library.

Functional tests are in "test" directory:

    cli.php - console script for testing purposes
    index.html - test script for any web server
    
Basic usage:

    use QrCode\QrCode;
    use \QrCode\Renderer\GoogleChartsRenderer;
    
    $qrCode = new QrCode("Test", 100, 100);
    $qrCode->setRenderer(new GoogleChartsRenderer());
    $content = $qrCode->generate();
    
