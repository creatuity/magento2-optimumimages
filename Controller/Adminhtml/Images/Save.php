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

class Save extends Action
{
    protected $imageFactory;

    protected $imageRepository;

    protected $config;

    protected $filesystemIo;

    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        ImageFactory $imageFactory,
        ImageRepositoryInterface $imageRepository,
        Config $config,
        File $filesystemIo,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->imageFactory = $imageFactory;
        $this->imageRepository = $imageRepository;
        $this->config = $config;
        $this->filesystemIo = $filesystemIo;
        $this->dataPersistor = $dataPersistor;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if( $data ) {
            /** @var ImageInterface $image */
            $image = $this->imageFactory->create();
            if( $this->imageRepository->existsByKey($data['key']) ) {
                $this->dataPersistor->set('creatuity_optimumimages_image', $data);
                $this->messageManager->addErrorMessage(__("Image Key \"%1\" already exists", $data['key']));
                return $resultRedirect->setPath('*/*/create');
            }
            $originImage = $data['origin_image'][0];
            unset($data['origin_image']);
            $image->setData($data);
            $image->setConversionStatus(ImageInterface::STATUS_NEW);
            $this->moveFile($originImage['file']);
            $image->setOriginLocation($originImage['file']);
            $this->imageRepository->save($image);
            $this->messageManager->addSuccessMessage(__("Successfully created \"%1\"", $image->getKey()));
            return $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function moveFile($file)
    {
        $src = $this->config->getAbsoluteBaseTmpMediaPath() . $file;
        $dest = $this->config->getAbsoluteBaseMediaPath() . $file;
        $this->filesystemIo->checkAndCreateFolder(dirname($dest));
        $this->filesystemIo->mv($src, $dest);
    }
}