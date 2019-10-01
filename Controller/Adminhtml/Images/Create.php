<?php
namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

use Creatuity\OptimumImages\Model\ImageFactory;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Create extends Action
{
    protected $imageFactory;

    protected $resultPageFactory;

    public function __construct(Action\Context $context, PageFactory $resultPageFactory, ImageFactory $imageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->imageFactory = $imageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Create New Image')));

        return $resultPage;
    }
}