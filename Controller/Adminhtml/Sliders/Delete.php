<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Sliders;

use Creatuity\OptimumImages\Api\Data\ImageInterface;
use Creatuity\OptimumImages\Api\SliderRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;

class Delete extends AbstractSliders
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

    public function execute()
    {
        try {
            $entity_id = $this->getRequest()->getParam('entity_id');
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            /** @var ImageInterface $slider */
            $slider = $this->sliderRepository->getById($entity_id);
            $this->sliderRepository->delete($slider);
            $this->messageManager->addSuccessMessage(__("Slider \"%1\" was deleted", $slider->getKey()));
        } catch (\Exception $e) {
            $this->messageManager->addSuccessMessage(__(
                "There was an error deleting \"%1\" slider",
                $slider->getKey()
            ));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
