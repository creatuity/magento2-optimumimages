<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;

class Delete extends AbstractImages
{
    /**
     * @var ImageRepositoryInterface
     */
    protected $imageRepository;

    public function __construct(
        Context $context,
        ImageRepositoryInterface $imageRepository
    ) {
        parent::__construct($context);
        $this->imageRepository = $imageRepository;
    }

    public function execute()
    {
        try {
            $entityId = $this->getRequest()->getParam('entity_id');
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            /** @var ImageInterface $image */
            $image = $this->imageRepository->getById($entityId);
            $this->imageRepository->delete($image);
            $this->messageManager->addSuccessMessage(__("Image \"%1\" was deleted", $image->getKey()));
        } catch (\Exception $e) {
            $this->messageManager->addSuccessMessage(__("There was an error deleting \"%1\" image", $image->getKey()));
        }
        return $resultRedirect->setPath('*/*/');
    }
}