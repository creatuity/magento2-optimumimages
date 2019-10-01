<?php
namespace Creatuity\OptimumImages\Model;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Magento\Framework\Model\AbstractModel;

class Image extends AbstractModel implements ImageInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Image::class);
    }

    public function getKey()
    {
        return $this->_getData(ImageInterface::KEY);
    }

    public function setKey($key)
    {
        return $this->setData(ImageInterface::KEY, $key);
    }

    public function getAlt()
    {
        return $this->_getData(ImageInterface::ALT);
    }

    public function setAlt($alt)
    {
        return $this->setData(ImageInterface::ALT, $alt);
    }

    public function getDimensionType()
    {
        return $this->_getData(ImageInterface::DIMENSION_TYPE);
    }

    public function setDimensionType($dimension_type)
    {
        return $this->setData(ImageInterface::DIMENSION_TYPE, $dimension_type);
    }

    public function getMobileDimension()
    {
        return $this->_getData(ImageInterface::MOBILE_DIMENSION);
    }

    public function setMobileDimension($mobile_dimension)
    {
        return $this->setData(ImageInterface::MOBILE_DIMENSION, $mobile_dimension);
    }

    public function getTabletDimension()
    {
        return $this->_getData(ImageInterface::TABLET_DIMENSION);
    }

    public function setTabletDimension($tablet_dimension)
    {
        return $this->setData(ImageInterface::TABLET_DIMENSION, $tablet_dimension);
    }

    public function getDesktopDimension()
    {
        return $this->_getData(ImageInterface::DESKTOP_DIMENSION);
    }

    public function setDesktopDimension($desktop_dimension)
    {
        return $this->setData(ImageInterface::DESKTOP_DIMENSION, $desktop_dimension);
    }

    public function getOriginLocation()
    {
        return $this->_getData(ImageInterface::ORIGIN_LOCATION);
    }

    public function setOriginLocation($origin_location)
    {
        return $this->setData(ImageInterface::ORIGIN_LOCATION, $origin_location);
    }

    public function getMobileLocation()
    {
        return $this->_getData(ImageInterface::MOBILE_LOCATION);
    }

    public function setMobileLocation($mobile_location)
    {
        return $this->setData(ImageInterface::MOBILE_LOCATION, $mobile_location);
    }

    public function getTabletLocation()
    {
        return $this->_getData(ImageInterface::TABLET_LOCATION);
    }

    public function setTabletLocation($tablet_location)
    {
        return $this->setData(ImageInterface::TABLET_LOCATION, $tablet_location);
    }

    public function getDesktopLocation()
    {
        return $this->_getData(ImageInterface::DESKTOP_LOCATION);
    }

    public function setDesktopLocation($desktop_location)
    {
        return $this->setData(ImageInterface::DESKTOP_LOCATION, $desktop_location);
    }

    public function getConversionStatus()
    {
        return $this->_getData(ImageInterface::CONVERSION_STATUS);
    }

    public function setConversionStatus($conversion_status)
    {
        return $this->setData(ImageInterface::CONVERSION_STATUS, $conversion_status);
    }

    public function getCreatedAt()
    {
        return $this->_getData(ImageInterface::CREATED_AT);
    }

    public function setCreatedAt($created_at)
    {
        return $this->setData(ImageInterface::CREATED_AT, $created_at);
    }

    public function getUpdatedAt()
    {
        return $this->_getData(ImageInterface::UPDATED_AT);
    }

    public function setUpdatedAt($updated_at)
    {
        return $this->setData(ImageInterface::UPDATED_AT, $updated_at);
    }
}