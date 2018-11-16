<?php

namespace Inchoo\CustomerTicket\Controller\Tickets;

use Inchoo\CustomerTicket\Helper\AuthHelper;
use Inchoo\CustomerTicket\Model\ResourceModel\Tickets;
use Inchoo\CustomerTicket\Model\TicketsFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\CouldNotSaveException;

class Close extends Action
{
    protected $authHelper;

    protected $ticketsFactory;

    protected $ticketsResource;

    public function __construct(
        Context $context,
        AuthHelper $authHelper,
        TicketsFactory $ticketsFactory,
        Tickets $ticketsResource
    ) {
        $this->authHelper = $authHelper;
        $this->ticketsFactory = $ticketsFactory;
        $this->ticketsResource = $ticketsResource;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->authHelper->checkIfLoggedIn();

        $resultRedirect = $this->resultRedirectFactory->create();

        $ticketId = $this->getRequest()->getParam('id');

        $ticket = $this->ticketsFactory->create();

        $this->ticketsResource->load($ticket, $ticketId);

        try {

            $ticket->setTicketStatus(0);

            $this->ticketsResource->save($ticket);

            $this->messageManager->addSuccessMessage(__('Ticket closed'));

            return $resultRedirect->setRefererUrl();

        } catch (\Exception $exc) {
            $this->messageManager->addErrorMessage(__('Status could not be changed'));
            return $resultRedirect->setRefererUrl();
        }

    }
}