<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Sliders;

use Magento\Backend\App\Action;

abstract class AbstractSliders extends Action
{
    public const ADMIN_RESOURCE = 'Creatuity_OptimumImages::sliders';

    protected function initPage()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Creatuity_OptimumImages::sliders');
        $this->_addBreadcrumb(__('Optimum Images'), __('Optimum Images'));
        $this->_addBreadcrumb(__('Sliders'), __('Sliders'));
        $this->prependTitle(__('Optimum Sliders'));
    }

    protected function prependTitle($title)
    {
        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
    }

    protected function renderPage()
    {
        $this->_view->renderLayout();
    }
}
