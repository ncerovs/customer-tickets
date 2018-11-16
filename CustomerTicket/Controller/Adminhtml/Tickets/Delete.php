<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Tickets;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\CouldNotDeleteException;

class Delete extends Action
{
    /**
     * @var \Inchoo\CustomerTicket\Model\TicketsFactory
     */
    protected $ticketsModelFactory;

    /**
     * @var \Inchoo\CustomerTicket\Model\ResourceModel\Tickets
     */
    protected $ticketsModelResource;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param \Inchoo\CustomerTicket\Model\TicketsFactory $ticketsModelFactory
     * @param \Inchoo\CustomerTicket\Model\ResourceModel\Tickets $ticketsModelResource
     */
    public function __construct(
        Action\Context $context,
        \Inchoo\CustomerTicket\Model\TicketsFactory $ticketsModelFactory,
        \Inchoo\CustomerTicket\Model\ResourceModel\Tickets $ticketsModelResource
    ) {
        $this->ticketsModelFactory = $ticketsModelFactory;
        $this->ticketsModelResource = $ticketsModelResource;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $ticketId = $this->getRequest()->getParam('id');

        $ticket = $this->ticketsModelFactory->create();

        try {

            $this->ticketsModelResource->load($ticket, $ticketId);

            $this->ticketsModelResource->delete($ticket);

            $this->messageManager->addSuccessMessage(__('Ticket deleted successfully'));

            return $resultRedirect->setPath('*/*/');

        } catch (\Exception $exc) {
            $this->messageManager->addErrorMessage(__('Delete failed' . $exc->getMessage()));

            return $resultRedirect->setPath('*/*/');
        }
    }
}