<?php
namespace Creatuity\OptimumImages\Model\ResourceModel\Slider;

use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Creatuity\OptimumImages\Model\Slider;
use Creatuity\OptimumImages\Model\ResourceModel\Slider as ResourceSlider;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = SliderInterface::ENTITY_ID;
    protected $_eventPrefix = "creatuity_optimumimages_slider_collection";
    protected $_eventObject = "slider_collection";

    protected function _construct()
    {
        $this->_init(Slider::class, ResourceSlider::class);
    }
}