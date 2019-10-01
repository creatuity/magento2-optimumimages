<?php
namespace Creatuity\OptimumImages\Api;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ImageRepositoryInterface
{
    public function save(ImageInterface $image);

    public function getById($imageId);

    public function getByKey($key);

    public function existsByKey($key);

    public function getList(SearchCriteriaInterface $searchCriteria);

    public function getListByStatus($status, $pageSize = 1);

    public function delete(ImageInterface $image);

    public function deleteById($imageId);
}