<?php
namespace Creatuity\OptimumImages\Ui\Component\Listing\Column;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

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
        if( isset($dataSource['data']['items']) ) {
            foreach( $dataSource['data']['items'] as &$item ) {
                if( isset($item['entity_id']) ) {
                    if( $item['conversion_status'] === ImageInterface::STATUS_ERROR ) {
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
        }

        return $dataSource;
    }
}