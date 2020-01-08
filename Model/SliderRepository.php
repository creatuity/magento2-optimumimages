<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Model;

use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Creatuity\OptimumImages\Api\SliderRepositoryInterface;
use Creatuity\OptimumImages\Model\ResourceModel\Slider as SliderResource;
use Creatuity\OptimumImages\Model\ResourceModel\Slider\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;

class SliderRepository implements SliderRepositoryInterface
{
    /**
     * @var SliderResource
     */
    private $resource;
    /**
     * @var SliderFactory
     */
    private $sliderFactory;
    /**
     * @var CollectionFactory
     */
    private $sliderCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        SliderResource $resource,
        SliderFactory $sliderFactory,
        CollectionFactory $sliderCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->sliderFactory = $sliderFactory;
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save(SliderInterface $slider): SliderInterface
    {
        try {
            /** @var AbstractModel $slider */
            $this->resource->save($slider);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the slider: %1', $exception->getMessage()), $exception);
        }
        return $slider;
    }

    public function getById($sliderId): SliderInterface
    {
        $slider = $this->sliderFactory->create();
        $this->resource->load($slider, $sliderId);
        if (!$slider->getId()) {
            throw new NoSuchEntityException(__('Slider with id "%1" does not exist.', $sliderId));
        }
        return $slider;
    }

    public function getByKey($key): SliderInterface
    {
        $slider = $this->sliderFactory->create();
        $this->resource->load($slider, $key, SliderInterface::KEY);
        if (!$slider->getId()) {
            throw new NoSuchEntityException(__('Slider with key "%1" does not exist.', $key));
        }

        return $slider;
    }

    public function existsByKey($key)
    {
        try {
            $this->getByKey($key);
            return true;
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    public function delete(SliderInterface $slider): bool
    {
        try {
            /** @var AbstractModel $slider */
            $this->resource->delete($slider);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the slider: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    public function deleteById($sliderId): bool
    {
        return $this->delete($this->getById($sliderId));
    }
}
