<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Sliders;

use Creatuity\OptimumImages\Api\SliderRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends AbstractSliders implements HttpGetActionInterface
{
    /**
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;

    public function __construct(
        Context $context,
        SliderRepositoryInterface $sliderRepository
    ) {
        parent::__construct($context);
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        try {
            $slider = $this->sliderRepository->getById($entityId);
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('This slider no longer exists.'));
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
        $this->prependTitle($slider->getId() ? sprintf('Edit Slider: %s', $slider->getKey()) : __('New Slider'));
        $this->_addBreadcrumb(
            $entityId ? __('Edit Slider') : __('New Slider'),
            $entityId ? __('Edit Slider') : __('New Slider')
        );
        $this->renderPage();
    }
}
