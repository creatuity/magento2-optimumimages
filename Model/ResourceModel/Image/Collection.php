<?php
namespace Creatuity\OptimumImages\Model\ResourceModel\Image;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Model\Image;
use Creatuity\OptimumImages\Model\ResourceModel\Image as ResourceImage;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = ImageInterface::ENTITY_ID;
    protected $_eventPrefix = "creatuity_optimumimages_image_collection";
    protected $_eventObject = "image_collection";

    protected function _construct()
    {
        $this->_init(Image::class, ResourceImage::class);
    }
}