<?php
namespace Creatuity\OptimumImages\Api;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\Data\ImageSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

interface ImageRepositoryInterface
{
    /**
     * @param ImageInterface $image
     * @return ImageInterface
     */
    public function save(ImageInterface $image): ImageInterface;

    /**
     * @param int $imageId
     * @return ImageInterface
     * @throws NoSuchEntityException
     */
    public function getById($imageId): ImageInterface;

    /**
     * @param string $key
     * @return ImageInterface
     * @throws NoSuchEntityException
     */
    public function getByKey($key): ImageInterface;

    /**
     * @param string $key
     * @return bool
     */
    public function existsByKey($key): bool;

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return ImageSearchResultsInterface|mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null);

    /**
     * @param string $status
     * @param int $pageSize
     * @return ImageSearchResultsInterface|mixed
     */
    public function getListByStatus($status, $pageSize = 1);

    /**
     * @param ImageInterface $image
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ImageInterface $image): bool;

    /**
     * @param int $imageId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($imageId): bool;
}