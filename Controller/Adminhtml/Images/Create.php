<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

use Creatuity\OptimumImages\Model\ImageFactory;
use Magento\Backend\App\Action;

class Create extends AbstractImages
{
    /**
     * @var ImageFactory
     */
    protected $imageFactory;

    public function __construct(Action\Context $context, ImageFactory $imageFactory)
    {
        parent::__construct($context);
        $this->imageFactory = $imageFactory;
    }

    public function execute()
    {
        $this->initPage();
        $this->_addBreadcrumb(__('New Image'), __('New Image'));
        $this->prependTitle((__('Create New Image')));

        $this->renderPage();
    }
}