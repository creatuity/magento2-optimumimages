<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Ui\Component\Listing\Column;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ImagesActions extends Column
{
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }
        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['entity_id'])) {
                continue;
            }

            if ($item['conversion_status'] === ImageInterface::STATUS_ERROR) {
                $this->addRestartAction($item);
            }
            $this->addEditAction($item);
            $this->addDeleteAction($item);
        }

        return $dataSource;
    }

    protected function addRestartAction(&$item): void
    {
        $item[$this->getData('name')]['restart'] = [
            'href' => $this->urlBuilder->getUrl(
                'creatuity_optimumimages/images/restart',
                ['entity_id' => $item['entity_id']]
            ),
            'label' => __('Restart'),
            'confirm' => [
                'title' => __('Restart %1', $item['key']),
                'message' => __('Are you sure you want to restart %1?', $item['key'])
            ],
            'hidden' => false
        ];
    }

    protected function addEditAction(&$item): void
    {
        $item[$this->getData('name')]['edit'] = [
            'href' => $this->urlBuilder->getUrl(
                'creatuity_optimumimages/images/edit',
                ['entity_id' => $item['entity_id']]
            ),
            'label' => __('Edit'),
            'hidden' => false
        ];
    }

    protected function addDeleteAction(&$item): void
    {
        $item[$this->getData('name')]['delete'] = [
            'href' => $this->urlBuilder->getUrl(
                'creatuity_optimumimages/images/delete',
                ['entity_id' => $item['entity_id']]
            ),
            'label' => __('Delete'),
            'confirm' => [
                'title' => __('Delete %1', $item['key']),
                'message' => __('Are you sure you want to delete a %1 record?', $item['key'])
            ],
            'hidden' => false
        ];
    }
}