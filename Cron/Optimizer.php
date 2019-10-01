<?php
namespace Creatuity\OptimumImages\Cron;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\Data\ImageSearchResultsInterface;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Creatuity\OptimumImages\Helper\Config;
use Creatuity\OptimumImages\Logger\Logger;
use Creatuity\OptimumImages\Model\Image\Config as ImageConfig;
use Creatuity\OptimumImages\Model\Image\Optimizer as ImageOptimizer;
use Magento\Framework\Filesystem\Io\File;

class Optimizer
{
    protected $logger;

    protected $imageRepository;

    protected $imageConfig;

    protected $filesystemIo;

    protected $optimizer;

    protected $config;

    public function __construct(
        Logger $logger,
        ImageRepositoryInterface $imageRepository,
        ImageConfig $imageConfig,
        File $filesystemIo,
        ImageOptimizer $optimizer,
        Config $config
    ) {
        $this->logger = $logger;
        $this->imageRepository = $imageRepository;
        $this->imageConfig = $imageConfig;
        $this->filesystemIo = $filesystemIo;
        $this->optimizer = $optimizer;
        $this->config = $config;
    }

    public function execute()
    {
        $this->logger->info("optimizer heartbeat");

        /** @var ImageSearchResultsInterface $images */
        $images = $this->imageRepository->getListByStatus(ImageInterface::STATUS_NEW, $this->config->getBatchSize());

        foreach( $images->getItems() as $image ) {
            $image->setConversionStatus(ImageInterface::STATUS_PROCESSING);
            $this->imageRepository->save($image);

            try {
                $image->setMobileLocation($this->imageConfig->addFilenameExtra($image->getOriginLocation(), $this->config->getMobileFileExtra(), "webp"));
                $image->setTabletLocation($this->imageConfig->addFilenameExtra($image->getOriginLocation(), $this->config->getTabletFileExtra(), "webp"));
                $image->setDesktopLocation($this->imageConfig->addFilenameExtra($image->getOriginLocation(), $this->config->getDesktopFileExtra(), "webp"));

                $this->optimizer->optimizeImage($image, $this->imageConfig->getAbsoluteBaseMediaPath(), $this->config->getImageQuality());
                $image->setConversionStatus(ImageInterface::STATUS_COMPLETE);
            } catch( \Exception $e) {
                $image->setConversionStatus(ImageInterface::STATUS_ERROR);

            }
            $this->imageRepository->save($image);
            $this->logger->info(sprintf("successfully converted %s located at %s", $image->getKey(), $image->getOriginLocation()));
        }
        return $this;
    }
}