<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Tickets;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_CustomerTicket::ticket_access');
    }
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Inchoo_CustomerTicket::ticket_access');
        $resultPage->getConfig()->getTitle()->prepend(__('Tickets'));
        return $resultPage;
    }
}