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
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    const STATUS_NEW = "NEW";
    const STATUS_PROCESSING = "PROCESSING";
    const STATUS_COMPLETE = "COMPLETE";
    const STATUS_ERROR = "ERROR";

    const DIMENSION_TYPE_WIDTH = "width";
    const DIMENSION_TYPE_HEIGHT = "height";

    public function getEntityId();

    public function setEntityId($entity_id);

    public function getKey();

    public function setKey($key);

    public function getAlt();

    public function setAlt($alt);

    public function getDimensionType();

    public function setDimensionType($dimension_type);

    public function getMobileDimension();

    public function setMobileDimension($mobile_dimension);

    public function getTabletDimension();

    public function setTabletDimension($tablet_dimension);

    public function getDesktopDimension();

    public function setDesktopDimension($desktop_dimension);

    public function getOriginLocation();

    public function setOriginLocation($origin_location);

    public function getMobileLocation();

    public function setMobileLocation($mobile_location);

    public function getTabletLocation();

    public function setTabletLocation($tablet_location);

    public function getDesktopLocation();

    public function setDesktopLocation($desktop_location);

    public function getConversionStatus();

    public function setConversionStatus($conversion_status);

    public function getCreatedAt();

    public function setCreatedAt($created_at);

    public function getUpdatedAt();

    public function setUpdatedAt($updated_at);
}