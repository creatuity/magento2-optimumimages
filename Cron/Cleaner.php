<?php
namespace Creatuity\OptimumImages\Cron;

use Creatuity\OptimumImages\Model\Image\Config as ImageConfig;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem\Glob;
use Psr\Log\LoggerInterface;

class Cleaner
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var ImageConfig
     */
    protected $imageConfig;
    /**
     * @var File
     */
    protected $filesystem;

    public function __construct(
        LoggerInterface $logger,
        ImageConfig $imageConfig,
        File $filesystem
    ) {
        $this->logger = $logger;
        $this->imageConfig = $imageConfig;
        $this->filesystem = $filesystem;
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
        $empty = true;
        foreach (Glob::glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
            $empty &= $this->filesystem->isDirectory($file) && $this->removeEmptySubFolders($file);
        }
        return $empty && $this->filesystem->deleteDirectory($path);
    }
}