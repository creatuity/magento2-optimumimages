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

class Cleaner
{
    protected $logger;

    protected $imageConfig;

    public function __construct(
        Logger $logger,
        ImageConfig $imageConfig
    ) {
        $this->logger = $logger;
        $this->imageConfig = $imageConfig;
    }

    public function execute()
    {
        $this->logger->info("cleaner heartbeat");

        try {
            $this->removeEmptySubFolders($this->imageConfig->getAbsoluteBaseTmpMediaPath());
            $this->removeEmptySubFolders($this->imageConfig->getAbsoluteBaseMediaPath());
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $this;
    }

    private function removeEmptySubFolders($path)
    {
        $empty=true;
        foreach (glob($path.DIRECTORY_SEPARATOR."*") as $file)
        {
            $empty &= is_dir($file) && $this->removeEmptySubFolders($file);
        }
        return $empty && rmdir($path);
    }
}