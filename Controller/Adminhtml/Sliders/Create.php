<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Sliders;

class Create extends AbstractSliders
{
    public function execute()
    {
        $this->initPage();
        $this->prependTitle((__('Create New Slider')));
        $this->renderPage();
    }
}