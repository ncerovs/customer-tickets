<?php

namespace Inchoo\CustomerTicket\Block;

use Inchoo\CustomerTicket\Model\ResourceModel\Tickets;
use Inchoo\CustomerTicket\Model\TicketsFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;

class TicketList extends Template
{
    /**
     * @var Tickets\CollectionFactory
     */
    protected $ticketsCollectionFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * TicketList constructor.
     * @param Template\Context $context
     * @param Tickets\CollectionFactory $collectionFactory
     * @param Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Tickets\CollectionFactory $collectionFactory,
        Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->ticketsCollectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return Tickets\Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTickets()
    {
        $collection = $this->ticketsCollectionFactory->create();

        $customer = $this->customerSession->getCustomerId();

        $website = $this->storeManager->getStore()->getWebsiteId();

        $tickets = $collection
            ->addFieldToSelect('*')
            ->addFieldToFilter('customer_id', $customer)
            ->addFieldToFilter('website_id', $website);

        return $tickets;
    }
}