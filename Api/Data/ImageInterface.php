<?php
namespace Creatuity\OptimumImages\Api\Data;

interface ImageInterface
{
    const DB_MAIN_TABLE = "creatuity_optimumimages_image";
    const ENTITY_ID = "entity_id";
    const KEY = "key";
    const ALT = "alt";
    const DIMENSION_TYPE = "dimension_type";
    const MOBILE_DIMENSION = "mobile_dimension";
    const TABLET_DIMENSION = "tablet_dimension";
    const DESKTOP_DIMENSION = "desktop_dimension";
    const ORIGIN_LOCATION = "origin_location";
    const MOBILE_LOCATION = "mobile_location";
    const TABLET_LOCATION = "tablet_location";
    const DESKTOP_LOCATION = "desktop_location";
    const CONVERSION_STATUS = "conversion_status";
    const LINK_URL = 'link_url';
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    const STATUS_NEW = "NEW";
    const STATUS_PROCESSING = "PROCESSING";
    const STATUS_COMPLETE = "COMPLETE";
    const STATUS_ERROR = "ERROR";

    const DIMENSION_TYPE_WIDTH = "width";
    const DIMENSION_TYPE_HEIGHT = "height";

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entity_id
     * @return ImageInterface
     */
    public function setEntityId($entity_id);

    /**
     * @return string
     */
    public function getKey();

    /**
     * @param string $key
     * @return mixed
     */
    public function setKey($key): ImageInterface;

    /**
     * @return string
     */
    public function getAlt();

    /**
     * @param string $alt
     * @return ImageInterface
     */
    public function setAlt($alt): ImageInterface;

    /**
     * @return string
     */
    public function getLinkUrl();

    /**
     * @param string $linkUrl
     * @return ImageInterface
     */
    public function setLinkUrl($linkUrl): ImageInterface;

    /**
     * @return string ImageInterface::DIMENSION_TYPE_*
     */
    public function getDimensionType();

    /**
     * @param string $dimension_type use ImageInterface::DIMENSION_TYPE_*
     * @return ImageInterface
     */
    public function setDimensionType($dimension_type): ImageInterface;

    /**
     * @return int
     */
    public function getMobileDimension();

    /**
     * @param int $mobile_dimension
     * @return ImageInterface
     */
    public function setMobileDimension($mobile_dimension): ImageInterface;

    /**
     * @return int
     */
    public function getTabletDimension();

    /**
     * @param int $tablet_dimension
     * @return ImageInterface
     */
    public function setTabletDimension($tablet_dimension): ImageInterface;

    /**
     * @return int
     */
    public function getDesktopDimension();

    /**
     * @param int $desktop_dimension
     * @return ImageInterface
     */
    public function setDesktopDimension($desktop_dimension): ImageInterface;

    /**
     * @return string
     */
    public function getOriginLocation();

    /**
     * @param string $origin_location
     * @return ImageInterface
     */
    public function setOriginLocation($origin_location): ImageInterface;

    /**
     * @return string
     */
    public function getMobileLocation();

    /**
     * @param string $mobile_location
     * @return ImageInterface
     */
    public function setMobileLocation($mobile_location): ImageInterface;

    /**
     * @return string
     */
    public function getTabletLocation();

    /**
     * @param string $tablet_location
     * @return ImageInterface
     */
    public function setTabletLocation($tablet_location): ImageInterface;

    /**
     * @return string
     */
    public function getDesktopLocation();

    /**
     * @param string $desktop_location
     * @return ImageInterface
     */
    public function setDesktopLocation($desktop_location): ImageInterface;

    /**
     * @return string one of ImageInterface::STATUS_*
     */
    public function getConversionStatus();

    /**
     * @param string $conversion_status use one of ImageInterface::STATUS_*
     * @return ImageInterface
     */
    public function setConversionStatus($conversion_status): ImageInterface;

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $created_at
     * @return ImageInterface
     */
    public function setCreatedAt($created_at): ImageInterface;

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updated_at
     * @return ImageInterface
     */
    public function setUpdatedAt($updated_at): ImageInterface;
}