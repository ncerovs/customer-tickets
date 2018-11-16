<?php

namespace Inchoo\CustomerTicket\Block\Adminhtml\Tickets;

class Ticket extends \Magento\Backend\Block\Template
{
    /**
     * @var
     */
    protected $timezone;

    /**
     * @var \Inchoo\CustomerTicket\Model\TicketsFactory
     */
    protected $ticketsFactory;

    /**
     * @var \Inchoo\CustomerTicket\Model\ResourceModel\Tickets
     */
    protected $ticketsResource;

    /**
     * @var
     */
    protected $ticketsCollection;

    /**
     * @var \Inchoo\CustomerTicket\Model\ResourceModel\Replies\CollectionFactory
     */
    protected $repliesCollectionFactory;

    /**
     * @var
     */
    protected $response;

    /**
     * Ticket constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Inchoo\CustomerTicket\Model\TicketsFactory $ticketsFactory
     * @param \Inchoo\CustomerTicket\Model\ResourceModel\Tickets $ticketsResource
     * @param \Inchoo\CustomerTicket\Model\ResourceModel\Replies\CollectionFactory $repliesCollectionFactory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Inchoo\CustomerTicket\Model\TicketsFactory $ticketsFactory,
        \Inchoo\CustomerTicket\Model\ResourceModel\Tickets $ticketsResource,
        \Inchoo\CustomerTicket\Model\ResourceModel\Replies\CollectionFactory $repliesCollectionFactory
    ) {
        $this->ticketsFactory = $ticketsFactory;
        $this->ticketsResource = $ticketsResource;
        $this->repliesCollectionFactory = $repliesCollectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Inchoo\CustomerTicket\Model\Tickets
     */
    public function getTicket()
    {
        $ticket = $this->ticketsFactory->create();

        $ticketId = $this->getRequest()->getParam('id');

        $this->ticketsResource->load($ticket, $ticketId);

        return $ticket;
    }

    /**
     * @param $ticketId
     * @return mixed
     */
    public function getTicketReplies($ticketId)
    {
        $collection = $this->repliesCollectionFactory->create();

        $replies = $collection
            ->addFieldToFilter('ticket_id', $ticketId);

        return $replies->getData();
    }
}