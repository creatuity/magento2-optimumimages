<?php

namespace Creatuity\OptimumImages\Ui\Component\Listing\Column;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Model\Image\Url;
use Creatuity\OptimumImages\Model\ImageRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    /**
     * @var Url
     */
    protected $imageUrl;
    /**
     * @var ImageRepository
     */
    protected $imageRepository;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Url $imageUrl,
        ImageRepository $imageRepository,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageUrl = $imageUrl;
        $this->imageRepository = $imageRepository;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (!$this->imageRepository->existsByKey($item['key'] ?? '')) {
                    continue;
                }
                $image = $this->imageRepository->getByKey($item[ImageInterface::KEY]);
                $item[$fieldName . '_src'] = $this->imageUrl->getImageUrl($image, ImageInterface::ORIGIN_LOCATION); // todo: this should be url to thumbnail image
                $item[$fieldName . '_alt'] = $this->getAlt($image);
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'creatuity_optimumimages/images/edit',
                    [ImageInterface::ENTITY_ID => $image->getEntityId()]
                );
                $item[$fieldName . '_orig_src'] = $this->imageUrl->getImageUrl($image, ImageInterface::ORIGIN_LOCATION);
            }
        }

        return $dataSource;
    }

    protected function getAlt(ImageInterface $image)
    {
        return $image->getKey() . ' thumbnail';
    }
}
