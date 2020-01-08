<?php

namespace Creatuity\OptimumImages\Model;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\Data\ImageSearchResultsInterfaceFactory;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Creatuity\OptimumImages\Model\ResourceModel\Image as ImageResource;
use Creatuity\OptimumImages\Model\ResourceModel\Image\CollectionFactory;
use Magento\Framework\Api\FilterFactory;
use Magento\Framework\Api\Search\FilterGroupFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;

class ImageRepository implements ImageRepositoryInterface
{
    /**
     * @var ImageResource
     */
    private $resource;
    /**
     * @var ImageFactory
     */
    private $imageFactory;
    /**
     * @var CollectionFactory
     */
    private $imageCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ImageSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var SearchCriteriaFactory
     */
    private $searchCriteriaFactory;
    /**
     * @var FilterFactory
     */
    private $filterFactory;
    /**
     * @var FilterGroupFactory
     */
    private $filterGroupFactory;

    public function __construct(
        ImageResource $resource,
        ImageFactory $imageFactory,
        CollectionFactory $imageCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ImageSearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaFactory $searchCriteriaFactory,
        FilterFactory $filterFactory,
        FilterGroupFactory $filterGroupFactory
    ) {
        $this->resource = $resource;
        $this->imageFactory = $imageFactory;
        $this->imageCollectionFactory = $imageCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaFactory = $searchCriteriaFactory;
        $this->filterFactory = $filterFactory;
        $this->filterGroupFactory = $filterGroupFactory;
    }

    public function save(ImageInterface $image): ImageInterface
    {
        try {
            /** @var AbstractModel $image */
            $this->resource->save($image);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the image: %1', $exception->getMessage()), $exception);
        }
        return $image;
    }

    public function getById($imageId): ImageInterface
    {
        $image = $this->imageFactory->create();
        $this->resource->load($image, $imageId);
        if (!$image->getId()) {
            throw new NoSuchEntityException(__('Image with id "%1" does not exist.', $imageId));
        }
        return $image;
    }

    public function getByKey($key): ImageInterface
    {
        $filter = $this->filterFactory->create()
            ->setField(ImageInterface::KEY)
            ->setValue($key)
            ->setConditionType('eq');

        $filterGroup = $this->filterGroupFactory->create()
            ->setFilters([$filter]);

        $searchCriteria = $this->searchCriteriaFactory->create()
            ->setFilterGroups([$filterGroup])
            ->setPageSize(1);

        $items = $this->getList($searchCriteria)->getItems();

        if (count($items) === 0) {
            throw new NoSuchEntityException(__('Image with key "%1" does not exist.', $key));
        }

        return array_values($items)[0];
    }

    public function existsByKey($key): bool
    {
        try {
            $this->getByKey($key);
            return true;
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        if (!$searchCriteria) {
            $searchCriteria = $this->searchCriteriaFactory->create();
        }
        $collection = $this->imageCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function getListByStatus($status, $pageSize = 1)
    {
        $filter = $this->filterFactory->create()
            ->setField(ImageInterface::CONVERSION_STATUS)
            ->setValue($status)
            ->setConditionType('eq');

        $filterGroup = $this->filterGroupFactory->create()
            ->setFilters([$filter]);

        $searchCriteria = $this->searchCriteriaFactory->create()
            ->setFilterGroups([$filterGroup])
            ->setPageSize($pageSize);

        return $this->getList($searchCriteria);
    }

    public function delete(ImageInterface $image): bool
    {
        try {
            /** @var AbstractModel $image */
            $this->resource->delete($image);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the page: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    public function deleteById($imageId): bool
    {
        return $this->delete($this->getById($imageId));
    }
}
