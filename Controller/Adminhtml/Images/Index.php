<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

class Index extends AbstractImages
{
    public function execute()
    {
        $this->initPage();
        $this->prependTitle(__('Images'));
        $this->renderPage();
    }
}