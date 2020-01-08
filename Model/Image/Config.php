<?php
namespace Creatuity\OptimumImages\Model\Image;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    /**
     * Path in /pub/media directory
     */
    const ENTITY_MEDIA_PATH = 'creatuity/optimumimages';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(StoreManagerInterface $storeManager, Filesystem $filesystem)
    {
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
    }

    public function getBaseMediaPath()
    {
        return self::ENTITY_MEDIA_PATH;
    }

    public function getTmpMediaUrl($file)
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $baseUrl . $this->getBaseTmpMediaPath() . '/' . $this->_prepareFile($file);
    }

    public function getMediaUrl($file)
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $baseUrl . $this->getBaseMediaPath() . '/' . $this->_prepareFile($file);
    }

    public function getBaseTmpMediaPath()
    {
        return 'tmp/' . $this->getBaseMediaPath();
    }

    public function getAbsoluteBaseTmpMediaPath()
    {
        $read = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        return $read->getAbsolutePath($this->getBaseTmpMediaPath());
    }

    public function getAbsoluteBaseMediaPath()
    {
        $read = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        return $read->getAbsolutePath($this->getBaseMediaPath());
    }

    public function addFilenameExtra($filename, $extra, $extension = null)
    {
        $pathinfo = pathinfo($filename);
        $extension = $extension ?: $pathinfo['extension'];
        return $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['filename'] . $extra . "." . $extension;
    }

    protected function _prepareFile($file)
    {
        return ltrim(str_replace('\\', '/', $file), '/');
    }
}
