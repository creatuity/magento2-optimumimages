<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Model;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Magento\Framework\Model\AbstractModel;

class Slider extends AbstractModel implements SliderInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Slider::class);
    }

    public function getKey()
    {
        return $this->_getData(SliderInterface::KEY);
    }

    public function setKey($key): SliderInterface
    {
        return $this->setData(SliderInterface::KEY, $key);
    }

    public function getAlt()
    {
        return $this->_getData(SliderInterface::ALT);
    }

    public function setAlt($alt): SliderInterface
    {
        return $this->setData(SliderInterface::ALT, $alt);
    }

    public function getSlideDelay()
    {
        return $this->_getData(SliderInterface::SLIDE_DELAY);
    }

    public function setSlideDelay($slide_delay): SliderInterface
    {
        return $this->setData(SliderInterface::SLIDE_DELAY, $slide_delay);
    }

    public function addImage(ImageInterface $image): SliderInterface
    {
        $images = $this->getImages();
        $images[] = $image->getEntityId();
        $this->setImages($images);
        return $this;
    }

    public function getImages()
    {
        return (array)$this->getData(SliderInterface::IMAGES);
    }

    public function setImages($imagesIds): SliderInterface
    {
        return $this->setData(SliderInterface::IMAGES, $imagesIds);
    }

    public function getCreatedAt()
    {
        return $this->_getData(SliderInterface::CREATED_AT);
    }

    public function setCreatedAt($created_at): SliderInterface
    {
        return $this->setData(SliderInterface::CREATED_AT, $created_at);
    }

    public function getUpdatedAt()
    {
        return $this->_getData(SliderInterface::UPDATED_AT);
    }

    public function setUpdatedAt($updated_at): SliderInterface
    {
        return $this->setData(SliderInterface::UPDATED_AT, $updated_at);
    }
}