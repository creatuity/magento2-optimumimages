<?php

namespace Creatuity\OptimumImages\Api;

use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface SliderRepositoryInterface
{
    /**
     * @param SliderInterface $slider
     * @return SliderInterface
     * @throws CouldNotSaveException
     */
    public function save(SliderInterface $slider): SliderInterface;

    /**
     * @param int $sliderId
     * @return SliderInterface
     * @throws NoSuchEntityException
     */
    public function getById($sliderId): SliderInterface;

    /**
     * @param string $key
     * @return SliderInterface
     * @throws NoSuchEntityException
     */
    public function getByKey($key): SliderInterface;

    /**
     * @param string $key
     * @return bool
     */
    public function existsByKey($key);

    /**
     * @param SliderInterface $slider
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(SliderInterface $slider);

    /**
     * @param int $sliderId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($sliderId);
}