<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Model\Image;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Url
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(StoreManagerInterface $_storeManager)
    {
        $this->_storeManager = $_storeManager;
    }

    /**
     * Returns image url
     *
     * @param ImageInterface $image
     * @param string $key
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageUrl(ImageInterface $image, $key)
    {
        $url = false;
        $image = $image->getData($key);
        if ($image) {
            if (is_string($image)) {
                $store = $this->_storeManager->getStore();

                $mediaBaseUrl = $store->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                );

                $url = $mediaBaseUrl
                    . ltrim(Config::ENTITY_MEDIA_PATH, '/')
                    . $image;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}
