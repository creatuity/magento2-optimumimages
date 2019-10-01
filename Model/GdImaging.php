<?php
namespace Creatuity\OptimumImages\Model;

class GdImaging
{
    public function getImageSize($path)
    {
        return getimagesize($path);
    }

    public function loadJpegImage($path)
    {
        return imagecreatefromjpeg($path);
    }

    public function loadNewImage($width, $height)
    {
        return imagecreatetruecolor($width, $height);
    }

    public function loadPngImage($path)
    {
        return imagecreatefrompng($path);
    }

    public function resampleImage($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight)
    {
        return imagecopyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
    }

    public function saveWebpImage($resource, $path, $quality = 80)
    {
        return imagewebp($resource, $path, $quality);
    }
}