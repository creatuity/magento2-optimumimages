<?php
namespace Creatuity\OptimumImages\Model\Image\Source;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Magento\Framework\Data\OptionSourceInterface;

class DimensionType implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['label' => 'Width',  'value' => ImageInterface::DIMENSION_TYPE_WIDTH],
            ['label' => 'Height', 'value' => ImageInterface::DIMENSION_TYPE_HEIGHT]
        ];
    }
}
