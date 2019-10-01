<?php
namespace Creatuity\OptimumImages\Model\ResourceModel;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Image extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(ImageInterface::DB_MAIN_TABLE, ImageInterface::ENTITY_ID);
    }
}