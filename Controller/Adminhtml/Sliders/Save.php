<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Sliders;

use Creatuity\OptimumImages\Api\Data\SliderInterface;
use Creatuity\OptimumImages\Api\SliderRepositoryInterface;
use Creatuity\OptimumImages\Model\Slider\DataProvider;
use Creatuity\OptimumImages\Model\SliderFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends AbstractSliders
{
    /**
     * @var SliderFactory
     */
    protected $sliderFactory;
    /**
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    public function __construct(
        Context $context,
        SliderFactory $sliderFactory,
        SliderRepositoryInterface $sliderRepository,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->sliderFactory = $sliderFactory;
        $this->sliderRepository = $sliderRepository;
        $this->dataPersistor = $dataPersistor;
    }

    public function execute()
    {
        if (!$this->getPost()) {
            return $this->somethingWentWrong();
        }
        if ($this->isDuplicatedKey()) {
            return $this->showDuplicationError();
        }

        try {
            $slider = $this->prepareSlider();
            $this->sliderRepository->save($slider);
        } catch (\Exception $exception) {
            return $this->somethingWentWrong();
        }

        return $this->showSuccess($slider);
    }

    protected function prepareSlider()
    {
        $images = $this->assignedImages();
        /** @var SliderInterface $slider */
        $slider = $this->isEdit()
            ? $this->sliderRepository->getById($this->getPost(SliderInterface::ENTITY_ID))
            : $this->sliderFactory->create();
        $slider->setData($this->getPost());
        $slider->setImages($images);
        return $slider;
    }

    protected function assignedImages()
    {
        $images = (array)$this->getPost('assigned_images', 'images');
        $images = $this->sortByPosition($images);

        return array_column($images, 'entity_id');
    }

    protected function sortByPosition($images)
    {
        $positions = array_column($images, 'position');
        array_multisort($positions, SORT_ASC, $images);
        return $images;
    }

    protected function isDuplicatedKey()
    {
        if (!$this->sliderRepository->existsByKey($this->getPost(SliderInterface::KEY))) {
            return false;
        }
        if ($this->isEdit()) {
            $image = $this->sliderRepository->getByKey($this->getPost(SliderInterface::KEY));
            return $image->getEntityId() != $this->getPost(SliderInterface::ENTITY_ID);
        }
        return true;
    }

    protected function isEdit()
    {
        return $this->getPost(SliderInterface::ENTITY_ID);
    }

    protected function somethingWentWrong()
    {
        $this->persistData();
        return $this->showError(__('Something went wront'), $this->_redirect->getRefererUrl());
    }

    protected function showDuplicationError()
    {
        $this->persistData();
        return $this->showError(
            __("Slider key \"%1\" already exists", $this->getPost(SliderInterface::KEY)),
            $this->_redirect->getRefererUrl()
        );
    }

    protected function persistData()
    {
        $this->dataPersistor->set(DataProvider::PERSISTOR_KEY, $this->getPost(null, null));
    }

    protected function showSuccess(SliderInterface $slider)
    {
        $this->messageManager->addSuccessMessage(
            __(
                "Successfully %1 \"%2\" slider",
                ($this->isEdit() ? 'saved' : 'created'),
                $slider->getKey()
            )
        );

        $redirect = $this->result();
        if ($this->getRequest()->getParam('back') == 'edit') {
            $redirect->setPath(
                '*/*/edit',
                [
                    SliderInterface::ENTITY_ID => $slider->getEntityId()
                ]
            );
        } elseif ($this->getRequest()->getParam('redirect_to_new')) {
            $redirect->setPath('*/*/create');
        }

        return $redirect;
    }

    protected function showError($message, $path)
    {
        $this->messageManager->addErrorMessage($message);
        return $this->result($path);
    }

    protected function result($path = '*/*/')
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath($path);
    }

    protected function getPost($key = null, $fieldset = 'general')
    {
        if (!$fieldset) {
            return $this->getRequest()->getPostValue($key);
        }
        $fieldsetData = $this->getRequest()->getPostValue($fieldset);
        return $key ? ($fieldsetData[$key] ?? null) : $fieldsetData;
    }
}
