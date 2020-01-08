<?php
namespace Creatuity\OptimumImages\Model\ResourceModel;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Model\Image\Config;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Image extends AbstractDb
{
    /**
     * @var Config
     */
    private $imageConfig;

    public function __construct(Context $context, Config $imageConfig, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
        $this->imageConfig = $imageConfig;
    }

    protected function _construct()
    {
        $this->_init(ImageInterface::DB_MAIN_TABLE, ImageInterface::ENTITY_ID);
    }

    public function delete(\Magento\Framework\Model\AbstractModel $object)
    {
        $result = parent::delete($object);

        $this->deleteFiles($object);

        return $result;
    }

    private function deleteFiles(ImageInterface $image)
    {
        $files = [
            $this->imageConfig->getAbsoluteBaseMediaPath() . $image->getOriginLocation(),
            $this->imageConfig->getAbsoluteBaseMediaPath() . $image->getMobileLocation(),
            $this->imageConfig->getAbsoluteBaseMediaPath() . $image->getTabletLocation(),
            $this->imageConfig->getAbsoluteBaseMediaPath() . $image->getDesktopLocation(),
        ];
        foreach ($files as $file) {
            if (file_exists($file) && is_file($file)) {
                unlink($file);
            }
        }
    }
}