<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Tickets;

use Inchoo\CustomerTicket\Model\ResourceModel\Tickets;
use Inchoo\CustomerTicket\Model\TicketsFactory;
use Magento\Backend\App\Action;

class Close extends Action
{
    /**
     * @var TicketsFactory
     */
    protected $ticketsModelFactory;

    /**
     * @var Tickets
     */
    protected $ticketsModelResource;

    /**
     * Close constructor.
     * @param Action\Context $context
     * @param TicketsFactory $ticketsModelFactory
     * @param Tickets $ticketsModelResource
     */
    public function __construct(
        Action\Context $context,
        TicketsFactory $ticketsModelFactory,
        Tickets $ticketsModelResource
    ) {
        $this->ticketsModelFactory = $ticketsModelFactory;
        $this->ticketsModelResource = $ticketsModelResource;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $ticketId = $this->getRequest()->getParam('id');

        $ticket = $this->ticketsModelFactory->create();

        try {
            $this->ticketsModelResource->load($ticket, $ticketId);

            $ticket->setTicketStatus(0);

            $this->ticketsModelResource->save($ticket);

            return $resultRedirect->setRefererUrl();

        } catch (\Exception $exc) {
            $this->messageManager->addErrorMessage(__('Ticket status could not be changed: ' . $exc->getMessage()));
            return $resultRedirect->setRefererUrl();
        }
    }
}