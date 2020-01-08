<?php
namespace Creatuity\OptimumImages\Cron;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\Data\ImageSearchResultsInterface;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Creatuity\OptimumImages\Model\Config;
use Creatuity\OptimumImages\Model\Image\Config as ImageConfig;
use Creatuity\OptimumImages\Model\Image\Optimizer as ImageOptimizer;
use Magento\Framework\Filesystem\Io\File;
use Psr\Log\LoggerInterface;

class Optimizer
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var ImageRepositoryInterface
     */
    protected $imageRepository;
    /**
     * @var ImageConfig
     */
    protected $imageConfig;
    /**
     * @var File
     */
    protected $filesystemIo;
    /**
     * @var ImageOptimizer
     */
    protected $optimizer;
    /**
     * @var Config
     */
    protected $config;

    public function __construct(
        LoggerInterface $logger,
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

        foreach ($images->getItems() as $image) {
            $image->setConversionStatus(ImageInterface::STATUS_PROCESSING);
            $this->imageRepository->save($image);

            try {
                $image->setMobileLocation($this->imageConfig->addFilenameExtra(
                    $image->getOriginLocation(),
                    $this->config->getMobileFileExtra(),
                    "webp"
                ));
                $image->setTabletLocation($this->imageConfig->addFilenameExtra(
                    $image->getOriginLocation(),
                    $this->config->getTabletFileExtra(),
                    "webp"
                ));
                $image->setDesktopLocation($this->imageConfig->addFilenameExtra(
                    $image->getOriginLocation(),
                    $this->config->getDesktopFileExtra(),
                    "webp"
                ));

                $this->optimizer->optimizeImage(
                    $image,
                    $this->imageConfig->getAbsoluteBaseMediaPath(),
                    $this->config->getImageQuality()
                );
                $image->setConversionStatus(ImageInterface::STATUS_COMPLETE);
            } catch (\Exception $e) {
                $image->setConversionStatus(ImageInterface::STATUS_ERROR);
                $this->logger->error(sprintf(
                    'Could not convert image "%s" located at %s, exception: %s',
                    $image->getKey(),
                    $image->getOriginLocation(),
                    $e->getMessage()
                ));
            }
            $this->imageRepository->save($image);
            $this->logger->info(sprintf(
                "successfully converted %s located at %s",
                $image->getKey(),
                $image->getOriginLocation()
            ));
        }
        return $this;
    }
}
