<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Ui\DataProvider\Slider\Form\Images;

use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as UiDataProvider;

class DataProvider extends UiDataProvider
{
    /**
     * @var ImageRepositoryInterface
     */
    protected $imageRepository;

    protected $imagesCount;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        ImageRepositoryInterface $imageRepository,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->imageRepository = $imageRepository;
    }

    public function getData()
    {
        return array_merge(
            parent::getData(),
            ['totalRecords' => $this->getImagesCount()]
        );
    }

    protected function getImagesCount()
    {
        if (!$this->imagesCount) {
            $this->imagesCount = $this->imageRepository->getList()->getTotalCount();
        }
        return $this->imagesCount;
    }
}
