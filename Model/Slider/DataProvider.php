<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Model\Slider;

use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Creatuity\OptimumImages\Model\ResourceModel\Slider\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    const PERSISTOR_KEY = 'creatuity_optimumimages_slider';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $imageCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $imageCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->dataPersistor = $dataPersistor;
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
                'general' => $slider->getData()
            ];
        }

        $data = $this->dataPersistor->get(self::PERSISTOR_KEY);
        if (!empty($data)) {
            $block = $this->collection->getNewEmptyItem();
            $block->setData($data);
            $this->loadedData[$block->getId()] = $block->getData();
            $this->dataPersistor->clear(self::PERSISTOR_KEY);
        }

        return $this->loadedData;
    }
}
