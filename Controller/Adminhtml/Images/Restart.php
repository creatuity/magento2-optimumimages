<?php
namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Creatuity\OptimumImages\Model\Image\Config;
use Creatuity\OptimumImages\Model\ImageFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Message\ManagerInterface;

class Restart extends Action
{
    protected $imageRepository;

    public function __construct(
        Action\Context $context,
        ImageRepositoryInterface $imageRepository
    ) {
        parent::__construct($context);
        $this->imageRepository = $imageRepository;
    }

    public function execute()
    {
        $entity_id = $this->getRequest()->getParam('entity_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        /** @var ImageInterface $image */
        try {
            $image = $this->imageRepository->getById($entity_id);
            $image->setConversionStatus(ImageInterface::STATUS_NEW);
            $this->imageRepository->save($image);
            $this->messageManager->addSuccessMessage(__("Image Conversion restarted for \"%1\"", $image->getKey()));
        } catch( \Exception $e ) {
            $this->messageManager->addSuccessMessage(__("There was an error restarting \"%1\"", $image->getKey()));
        }
        return $resultRedirect->setPath('*/*/');
    }
}