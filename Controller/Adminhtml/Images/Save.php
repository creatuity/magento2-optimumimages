<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Creatuity\OptimumImages\Model\Image;
use Creatuity\OptimumImages\Model\Image\Config;
use Creatuity\OptimumImages\Model\ImageFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Filesystem\Io\File;

class Save extends AbstractImages
{
    /**
     * @var ImageFactory
     */
    protected $imageFactory;
    /**
     * @var ImageRepositoryInterface
     */
    protected $imageRepository;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var File
     */
    protected $filesystemIo;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    public function __construct(
        Context $context,
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
        $data = $this->getPost();
        if ($data) {
            if ($this->isCreatingDuplicatedKey()) {
                return $this->duplicationResult();
            }

            $image = $this->prepareImage($data);
            $this->imageRepository->save($image);

            return $this->successResult($image);
        }

        return $this->redirect()->setPath('*/*/');
    }

    protected function isCreatingDuplicatedKey()
    {
        if (!$this->imageRepository->existsByKey($this->getRequest()->getPostValue(ImageInterface::KEY))) {
            return false;
        }
        if ($this->isEdit()) {
            $image = $this->imageRepository->getByKey($this->getRequest()->getPostValue(ImageInterface::KEY));
            return $image->getEntityId() != $this->getRequest()->getPostValue(ImageInterface::ENTITY_ID);
        }
    }

    protected function duplicationResult(): Redirect
    {
        $this->dataPersistor->set('creatuity_optimumimages_image', $this->getPost());
        $this->messageManager->addErrorMessage(__(
            "Image Key \"%1\" already exists",
            $this->getPost(ImageInterface::KEY)
        ));
        return $this->isEdit()
            ? $this->redirect()->setPath(
                '*/*/edit',
                ['entity_id' => $this->getRequest()->getPostValue(ImageInterface::ENTITY_ID)]
            )
            : $this->redirect()->setPath('*/*/create');
    }

    protected function successResult(ImageInterface $image)
    {
        $this->messageManager->addSuccessMessage(__(
            "Successfully %1 \"%2\"",
            ($this->isEdit() ? 'saved' : 'created'),
            $image->getKey()
        ));
        if ($this->getRequest()->getParam('back') == 'edit') {
            return $this->redirect()->setPath(
                '*/*/edit',
                [
                    ImageInterface::ENTITY_ID => $image->getEntityId()
                ]
            );
        } elseif ($this->getRequest()->getParam('redirect_to_new')) {
            return $this->redirect()->setPath('*/*/create');
        }

        return $this->redirect()->setPath('*/*/');
    }

    protected function isEdit()
    {
        return $this->getRequest()->getPostValue(ImageInterface::ENTITY_ID);
    }

    private function moveFile($file)
    {
        $src = $this->config->getAbsoluteBaseTmpMediaPath() . $file;
        $dest = $this->config->getAbsoluteBaseMediaPath() . $file;
        $this->filesystemIo->checkAndCreateFolder(dirname($dest));
        $this->filesystemIo->mv($src, $dest);
    }

    protected function prepareImage($data): ImageInterface
    {
        /** @var Image $image */
        $image = $this->imageFactory->create();
        $image->setData($data);
        if (isset($data['origin_image'][0]['file'])) {
            $this->moveFile($data['origin_image'][0]['file']);
            $image->setOriginLocation($data['origin_image'][0]['file']);
        }
        $image->setConversionStatus(ImageInterface::STATUS_NEW);
        return $image;
    }

    protected function getPost($key = null)
    {
        return $this->getRequest()->getPostValue($key);
    }

    protected function redirect(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect;
    }
}
