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

class Delete extends Action
{
    protected $imageRepository;

    protected $imageConfig;

    public function __construct(
        Action\Context $context,
        ImageRepositoryInterface $imageRepository,
        Config $imageConfig
    ) {
        parent::__construct($context);
        $this->imageRepository = $imageRepository;
        $this->imageConfig = $imageConfig;
    }

    public function execute()
    {
        $entity_id = $this->getRequest()->getParam('entity_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        /** @var ImageInterface $image */
        try {
            $image = $this->imageRepository->getById($entity_id);
            $this->deleteFiles($image);
            $this->imageRepository->delete($image);
            $this->messageManager->addSuccessMessage(__("Image Conversion restarted for \"%1\"", $image->getKey()));
        } catch( \Exception $e ) {
            $this->messageManager->addSuccessMessage(__("There was an error restarting \"%1\"", $image->getKey()));
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function deleteFiles(ImageInterface $image)
    {
        $files = [
            $this->imageConfig->getAbsoluteBaseMediaPath() . $image->getOriginLocation(),
            $this->imageConfig->getAbsoluteBaseMediaPath() . $image->getMobileLocation(),
            $this->imageConfig->getAbsoluteBaseMediaPath() . $image->getTabletLocation(),
            $this->imageConfig->getAbsoluteBaseMediaPath() . $image->getDesktopLocation(),
        ];
        foreach($files as $file) {
            if( file_exists($file) ) unlink($file);
        }
    }
}