<?php

namespace DPluschaev\QrCode\Traits;

trait RendererPropertiesTrait
{
    /**
     * @var string The data to encode. Data can be digits (0-9), alphanumeric characters,
     * binary bytes of data, or Kanji. You cannot mix data types within a QR code
     */
    public $dataString;

    /**
     * @var int Image width
     */
    public $width;

    /**
     * @var int Image height
     */
    public $height;

    /**
     * @var string How to encode the data in the QR code
     */
    public $outputEncoding = "UTF-8";

    /**
     * @var string QR codes support four levels of error correction to enable recovery of missing, misread,
     * or obscured data. Greater redundancy is achieved at the cost of being able to store less data. Here
     * are the supported values:

        L - [Default] Allows recovery of up to 7% data loss
        M - Allows recovery of up to 15% data loss
        Q - Allows recovery of up to 25% data loss
        H - Allows recovery of up to 30% data loss
     */
    public $errorCorrectionLevel = "L";

    /**
     * @var string The width of the white border around the data portion of the code. This is in rows, not
     * in pixels. The default value is 4
     */
    public $margin = 4;
}
