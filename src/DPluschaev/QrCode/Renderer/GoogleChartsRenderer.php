<?php

namespace DPluschaev\QrCode\Renderer;

use DPluschaev\QrCode\Exceptions\HttpRequestException;
use DPluschaev\QrCode\Exceptions\InvalidParameterException;
use DPluschaev\QrCode\Interfaces\RendererInterface;
use DPluschaev\QrCode\QrCode;

class GoogleChartsRenderer implements RendererInterface
{
    const ROOT_URL = "https://chart.googleapis.com/chart?";
    const USE_POST_CHAR_LIMIT = 1900;
    const HTTP_CONNECTION_TIMEOUT_SECONDS = 20;

    /**
     * @param QrCode $qrCode
     * @return string
     * @throws InvalidParameterException | HttpRequestException
     */
    public function run(QrCode $qrCode)
    {
        $this->validate($qrCode);
        return $this->processRequest($this->getOptions($qrCode));
    }

    /**
     * @param QrCode $qrCode
     * @return array
     */
    protected function getOptions(QrCode $qrCode)
    {
        return [
            "cht" => "qr",
            "chs" => intval($qrCode->width) . "x" . $qrCode->height,
            "chl" => $qrCode->dataString,
            "choe" => $qrCode->outputEncoding,
            "chld" => $qrCode->errorCorrectionLevel . "|" . $qrCode->margin,
        ];
    }

    /**
     * @param QrCode $qrCode
     * @throws InvalidParameterException
     */
    protected function validate(QrCode $qrCode)
    {
        if (strlen($qrCode->dataString) == 0) {
            throw new InvalidParameterException("dataString cannot be empty");
        }
        if (intval($qrCode->width) == 0) {
            throw new InvalidParameterException("width cannot be 0");
        }
        if (intval($qrCode->height) == 0) {
            throw new InvalidParameterException("height cannot be 0");
        }
    }

    /**
     * @param array $options
     * @return string
     * @throws HttpRequestException
     */
    protected function processRequest(array $options)
    {
        $contextOptions = $this->prepareContextOptions($options);
        return $this->sendRequest($contextOptions);
    }

    /**
     * @param array $contextOptions
     * @return string
     * @throws HttpRequestException
     */
    protected function sendRequest(array $contextOptions)
    {
        try {
            $context = stream_context_create($contextOptions);
            $result = @file_get_contents(self::ROOT_URL, false, $context);
            if ($result === false) {
                $error = error_get_last();
                throw new HttpRequestException(empty($error['message']) ? "Unknown HTTP I/O error" : $error['message']);
            }
            return $result;
        } catch (\Exception $e) {
            throw new HttpRequestException($e);
        }
    }

    /**
     * @param array $options
     * @return array
     */
    protected function prepareContextOptions(array $options)
    {
        $urlStr = http_build_query($options);

        $headers = [
            "Content-Type: application/x-www-form-urlencoded",
        ];
        $contextOptions = [
            "http" => [
                "method" => "POST",
                "timeout" => self::HTTP_CONNECTION_TIMEOUT_SECONDS,
                "content" => $urlStr,
                "header" => implode("\r\n", $headers),
            ]
        ];

        return $contextOptions;
    }
}
