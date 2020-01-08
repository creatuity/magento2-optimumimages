<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

use Creatuity\OptimumImages\Model\ResourceModel\Image\CollectionFactory;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Creatuity\OptimumImages\Model\ResourceModel\Image as ImageResource;

class MassDelete extends AbstractImages implements HttpPostActionInterface
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var ImageResource
     */
    protected $imageResource;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, ImageResource $imageResource)
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->imageResource = $imageResource;
    }

    /**
     * Execute action
     *
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $image) {
            $this->imageResource->delete($image);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
