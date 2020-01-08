<?php

namespace Creatuity\OptimumImages\Model\Image;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Model\GdImaging;

class Optimizer
{
    /**
     * @var GdImaging
     */
    private $gdImaging;

    public function __construct(GdImaging $gdImaging)
    {
        $this->gdImaging = $gdImaging;
    }

    public function optimizeImage(ImageInterface $image, $basePath, $quality)
    {
        $this->createWebpImage(
            $basePath . $image->getOriginLocation(),
            $basePath . $image->getMobileLocation(),
            $image->getMobileDimension(),
            $image->getDimensionType(),
            $quality
        );
        $this->createWebpImage(
            $basePath . $image->getOriginLocation(),
            $basePath . $image->getTabletLocation(),
            $image->getTabletDimension(),
            $image->getDimensionType(),
            $quality
        );
        $this->createWebpImage(
            $basePath . $image->getOriginLocation(),
            $basePath . $image->getDesktopLocation(),
            $image->getDesktopDimension(),
            $image->getDimensionType(),
            $quality
        );
    }

    private function createWebpImage($srcImagePath, $dstImagePath, $newDimension, $dimensionType, $quality)
    {
        list($srcWidth, $srcHeight) = $this->gdImaging->getImageSize($srcImagePath);
        list($dstWidth, $dstHeight) = $this->calculateNewImageSize($srcWidth,
            $srcHeight,
            $newDimension,
            $dimensionType);

        $srcImage = $this->loadImage($srcImagePath);
        $dstImage = $this->resizeImage($srcImage, $dstWidth, $dstHeight, $srcWidth, $srcHeight);

        if (!$this->gdImaging->saveWebpImage($dstImage, $dstImagePath, $quality)) {
            throw new \Exception(__("Could not save webp image"));
        }
    }

    private function calculateNewImageSize($srcWidth, $srcHeight, $newDimension, $dimensionType)
    {
        $aspectRatio = $srcWidth / $srcHeight;

        if ($dimensionType === ImageInterface::DIMENSION_TYPE_WIDTH) {
            return [$newDimension, ($newDimension / $aspectRatio)];
        } elseif ($dimensionType === ImageInterface::DIMENSION_TYPE_HEIGHT) {
            return [($newDimension * $aspectRatio), $newDimension];
        } else {
            throw new \Exception(__("Dimension Type not supported"));
        }
    }

    private function loadImage($path)
    {
        if (!\is_readable($path)) {
            throw new \Exception(__("Cannot load image: '%1'", $path));
        }

        $extension = pathinfo($path)['extension'];

        if (in_array($extension, ['jpg', 'jpeg'])) {
            return $this->gdImaging->loadJpegImage($path);
        }

        if (in_array($extension, ['png'])) {
            return $this->gdImaging->loadPngImage($path);
        }

        throw new \Exception("Image format not supported");
    }

    private function resizeImage($srcImage, $dstWidth, $dstHeight, $srcWidth, $srcHeight)
    {
        $dstImage = $this->gdImaging->loadNewImage($dstWidth, $dstHeight);

        if (!$this->gdImaging->resampleImage(
            $dstImage,
            $srcImage,
            0,
            0,
            0,
            0,
            $dstWidth,
            $dstHeight,
            $srcWidth,
            $srcHeight
        )) {
            throw new \Exception(__("Image could not be resized"));
        }

        return $dstImage;
    }
}
