<?php

namespace Creatuity\OptimumImages\Block\Widget;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\Data\SliderImageInterface;
use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Creatuity\OptimumImages\Api\SliderRepositoryInterface;
use Creatuity\OptimumImages\Model\Image\Config;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Slider extends Template implements BlockInterface
{
    protected $_template = "widget/optimum_slider.phtml";

    /**
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;
    /**
     * @var ImageRepositoryInterface
     */
    protected $imageRepository;

    protected $loadedSlider = null;

    protected $config;

    public function __construct(
        Template\Context $context,
        SliderRepositoryInterface $sliderRepository,
        ImageRepositoryInterface $imageRepository,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sliderRepository = $sliderRepository;
        $this->imageRepository = $imageRepository;
        $this->config = $config;
    }

    public function getMediaUrl($location)
    {
        return $this->config->getMediaUrl($location);
    }

    /**
     * @return SliderInterface|null
     * @throws NoSuchEntityException
     */
    public function getSlider()
    {
        if (is_null($this->loadedSlider)) {
            $this->loadedSlider = $this->sliderRepository->getByKey($this->getData('slider_key'));
        }
        return $this->loadedSlider;
    }

    /**
     * @return ImageInterface[]
     * @throws NoSuchEntityException
     */
    public function getSliderImages()
    {
        $images = $this->getSlider()->getImages();
        $imageIds = array_column($images, SliderImageInterface::IMAGE_ID);

        $images = [];
        foreach ($imageIds as $imageId) {
            $images[] = $this->imageRepository->getById($imageId);
        }

        return $images;
    }

    /**
     * @param ImageInterface $image
     * @return string
     */
    public function getLinkUrl(ImageInterface $image)
    {
        $link = $image->getLinkUrl();
        return $link ? $link : '#';
    }
}