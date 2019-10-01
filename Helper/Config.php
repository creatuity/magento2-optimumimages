<?php
namespace Creatuity\OptimumImages\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const BATCH_SIZE = 'creatuity_optimumimages/optimizer/batch_size';
    const IMAGE_QUALITY = 'creatuity_optimumimages/optimizer/image_quality';
    const MOBILE_FILE_EXTRA = 'creatuity_optimumimages/optimizer/mobile_file_extra';
    const TABLET_FILE_EXTRA = 'creatuity_optimumimages/optimizer/tablet_file_extra';
    const DESKTOP_FILE_EXTRA = 'creatuity_optimumimages/optimizer/desktop_file_extra';

    public function getBatchSize($storeId = null)
    {
        return $this->scopeConfig->getValue(Config::BATCH_SIZE, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getImageQuality($storeId = null)
    {
        return $this->scopeConfig->getValue(Config::IMAGE_QUALITY, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getMobileFileExtra($storeId = null)
    {
        return $this->scopeConfig->getValue(Config::MOBILE_FILE_EXTRA, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getTabletFileExtra($storeId = null)
    {
        return $this->scopeConfig->getValue(Config::TABLET_FILE_EXTRA, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getDesktopFileExtra($storeId = null)
    {
        return $this->scopeConfig->getValue(Config::DESKTOP_FILE_EXTRA, ScopeInterface::SCOPE_STORE, $storeId);
    }
}