<?php

namespace DPluschaev\QrCode\Interfaces;

use DPluschaev\QrCode\QrCode;

interface RendererInterface
{
    /**
     * @param QrCode $qrCode
     * @return string
     */
    public function run(QrCode $qrCode);
}
