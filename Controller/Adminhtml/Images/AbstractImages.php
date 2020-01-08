<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Controller\Adminhtml\Images;

use Magento\Backend\App\Action;

abstract class AbstractImages extends Action
{
    public const ADMIN_RESOURCE = 'Creatuity_OptimumImages::images';

    protected function initPage()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Creatuity_OptimumImages::images');
        $this->_addBreadcrumb(__('Optimum Images'), __('Optimum Images'));
        $this->_addBreadcrumb(__('Images'), __('Images'));
        $this->prependTitle(__('Optimum Images'));
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
