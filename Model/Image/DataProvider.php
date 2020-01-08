<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Model\Image;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Model\Image\Url as ImageUrl;
use Creatuity\OptimumImages\Model\ResourceModel\Image\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var FileInfo
     */
    protected $fileInfo;
    /**
     * @var ImageUrl
     */
    protected $imageUrl;
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $imageCollectionFactory,
        FileInfo $fileInfo,
        ImageUrl $imageUrl,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $imageCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->fileInfo = $fileInfo;
        $this->imageUrl = $imageUrl;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $images = $this->collection->getItems();
        /** @var $image ImageInterface */
        foreach ($images as $image) {
            $this->loadedData[$image->getEntityId()] = $this->imageData($image);
        }

        return $this->loadedData;
    }

    protected function imageData(ImageInterface $image)
    {
        $data = $image->getData();

        $key = ImageInterface::ORIGIN_LOCATION;
        if ($image->getData($key)) {
            $data['origin_image'][0] = $this->imageUploaderInfo($image, $key);
        }

        return $data;
    }

    protected function imageUploaderInfo(ImageInterface $image, $key)
    {
        $data = [];
        $fileName = $image->getData($key);

        if ($this->fileInfo->isExist($fileName)) {
            $data['url'] = ($this->fileInfo->isBeginsWithMediaDirectoryPath($fileName))
                ? $fileName
                : $this->imageUrl->getImageUrl($image, $key);
            $stat = $this->fileInfo->getStat($fileName);
            $data['size'] = isset($stat) ? $stat['size'] : 0;
            $data['name'] = basename($fileName);
            $data['type'] = $this->fileInfo->getMimeType($fileName);
        }

        return $data;
    }
}
