<?php
namespace Creatuity\OptimumImages\Block\Widget;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Creatuity\OptimumImages\Model\Image\Config;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Image extends Template implements BlockInterface
{
    protected $_template = "widget/optimum_image.phtml";

    protected $imageRepository;

    protected $loadedImage = null;

    protected $config;

    public function __construct(
        Template\Context $context,
        ImageRepositoryInterface $imageRepository,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->imageRepository = $imageRepository;
        $this->config = $config;
    }

    public function getMediaUrl($location)
    {
        return $this->config->getMediaUrl($location);
    }

    /**
     * @return ImageInterface
     */
    public function getImage()
    {
        if( is_null($this->loadedImage) ) {
            $this->loadedImage = $this->imageRepository->getByKey($this->getData('image_key'));
        }
        return $this->loadedImage;
    }
}