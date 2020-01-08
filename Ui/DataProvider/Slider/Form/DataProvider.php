<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Ui\DataProvider\Slider\Form;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\Data\SliderImageInterface;
use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Creatuity\OptimumImages\Api\SliderRepositoryInterface;
use Creatuity\OptimumImages\Model\Image\Url;
use Creatuity\OptimumImages\Model\ResourceModel\Slider\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    const DATA__SOURCE_GENERAL = 'general';
    const DATA__SOURCE_IMAGES = 'images';
    const DATA__SCOPE_ASSIGNED_IMAGES = 'assigned_images';

    /**
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;
    /**
     * @var ImageRepositoryInterface
     */
    protected $imageRepository;
    /**
     * @var Url
     */
    protected $imageUrl;
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $imageCollectionFactory,
        SliderRepositoryInterface $sliderRepository,
        ImageRepositoryInterface $imageRepository,
        Url $imageUrl,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $imageCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->sliderRepository = $sliderRepository;
        $this->imageRepository = $imageRepository;
        $this->imageUrl = $imageUrl;
    }


    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $sliders = $this->collection->getItems();
        /** @var $slider SliderInterface */
        foreach ($sliders as $slider) {
            $this->loadedData[$slider->getEntityId()] = [
                self::DATA__SOURCE_GENERAL => $slider->getData(),
                self::DATA__SOURCE_IMAGES => [
                    self::DATA__SCOPE_ASSIGNED_IMAGES => $this->imagesData($slider)
                ]
            ];
        }

        return $this->loadedData;
    }

    protected function imagesData(SliderInterface $slider)
    {
        $slider = $this->sliderRepository->getById($slider->getId());
        $images = $slider->getImages();

        $imagesData = [];
        foreach ($images as $image) {
            $imagesData[] = $this->imageData($image);
        }

        return $imagesData;
    }

    protected function imageData($image)
    {
        $image = $this->imageRepository->getById($image[SliderImageInterface::IMAGE_ID]);

        return [
            'entity_id' => $image->getEntityId(),
            'thumbnail' => $this->imageUrl->getImageUrl($image, ImageInterface::ORIGIN_LOCATION),
            'key' => $image->getKey(),
            'position' => $image[SliderImageInterface::POSITION]
        ];
    }
}
