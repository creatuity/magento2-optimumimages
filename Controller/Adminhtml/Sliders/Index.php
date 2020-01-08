<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Sliders;

class Index extends AbstractSliders
{
    public function execute()
    {
        $this->initPage();
        $this->prependTitle(__('Sliders'));
        $this->renderPage();
    }
}