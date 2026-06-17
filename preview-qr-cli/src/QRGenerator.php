<?php

namespace PreviewQrCli;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QRGenerator
{
    private string $outputPath;
    private int $size;
    private string $format;

    public function __construct(
        string $outputPath,
        int $size = 300,
        string $format = 'svg'
    ) {
        $this->outputPath = rtrim($outputPath, DIRECTORY_SEPARATOR);
        $this->size = $size;
        $this->format = $format;
    }

    /**
     * Génère une image QR code pour une URL donnée
     */
    public function generate(string $url, string $filename): string
    {
        $fullPath = $this->outputPath . DIRECTORY_SEPARATOR . $filename . '.' . $this->format;

        $renderer = new ImageRenderer(
            new RendererStyle($this->size, 4),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $writer->writeFile($url, $fullPath);

        return $fullPath;
    }

    /**
     * Génère et retourne les données binaires de l'image QR
     */
    public function generateBinary(string $url): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle($this->size, 4),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        return $writer->writeString($url);
    }

    /**
     * Génère un QR code en base64
     */
    public function generateBase64(string $url): string
    {
        $binary = $this->generateBinary($url);
        return base64_encode($binary);
    }
}
