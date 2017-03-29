<?php

namespace DPluschaev\QrCode;

use DPluschaev\QrCode\Interfaces\RendererInterface;
use DPluschaev\QrCode\Traits\RendererPropertiesTrait;

class QrCode
{
    use RendererPropertiesTrait;

    /**
     * @var RendererInterface Renderer
     */
    protected $renderer;

    /**
     * @param string $dataString
     * @param int $width
     * @param int $height
     */
    public function __construct($dataString = '', $width = 0, $height = 0)
    {
        $this->dataString = $dataString;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @param RendererInterface $renderer
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->renderer->run($this);
    }
}
