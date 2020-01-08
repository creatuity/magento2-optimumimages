<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

use Creatuity\OptimumImages\Api\ImageRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Edit extends AbstractImages implements HttpGetActionInterface
{
    /**
     * @var ImageRepositoryInterface
     */
    protected $imageRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        ImageRepositoryInterface $imageRepository
    ) {
        parent::__construct($context);
        $this->imageRepository = $imageRepository;
    }

    /**
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        try {
            $image = $this->imageRepository->getById($entityId);
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('This image no longer exists.'));
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong.'));
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $this->initPage();
        $this->prependTitle($image->getId() ? sprintf('Edit image: %s', $image->getKey()) : __('New Image'));
        $this->_addBreadcrumb(
            $entityId ? __('Edit Image') : __('New Image'),
            $entityId ? __('Edit Image') : __('New Image')
        );
        $this->renderPage();
    }
}
