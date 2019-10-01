<?php
namespace Creatuity\OptimumImages\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ImageSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return ImageInterface[]
     */
    public function getItems();

    /**
     * @param ImageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
