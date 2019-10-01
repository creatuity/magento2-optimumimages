<?php
namespace Creatuity\OptimumImages\Model\Image;

use Creatuity\OptimumImages\Model\ResourceModel\Image\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
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
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if( isset($this->loadedData) ) {
            return $this->loadedData;
        }
        $images = $this->collection->getItems();
        /** @var $image ImageInterface */
        foreach ($images as $image) {
            $this->loadedData[$image->getEntityId()] = $image->getData();
        }

        $data = $this->dataPersistor->get('creatuity_optimumimages_image');
        if ( !empty($data) ) {
            $image = $this->collection->getNewEmptyItem();
            $image->setData($data);
            $this->loadedData[$image->getEntityId()] = $image->getData();
            $this->dataPersistor->clear('creatuity_optimumimages_image');
        }

        return $this->loadedData;
    }
}
