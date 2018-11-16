<?php

namespace Inchoo\CustomerTicket\Controller\Tickets;

use Inchoo\CustomerTicket\Helper\AuthHelper;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Save extends Action
{
    protected $formKeyValidator;

    protected $customerSession;

    protected $storeManager;

    protected $timezone;

    protected $ticketsFactory;

    protected $ticketsResource;

    protected $authHelper;

    public function __construct(
        Context $context,
        Validator $formKeyValidator,
        Session $customerSession,
        TimezoneInterface $timezone,
        AuthHelper $authHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Inchoo\CustomerTicket\Model\TicketsFactory $ticketsFactory,
        \Inchoo\CustomerTicket\Model\ResourceModel\Tickets $ticketsResource
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->timezone = $timezone;
        $this->authHelper = $authHelper;
        $this->ticketsFactory = $ticketsFactory;
        $this->ticketsResource = $ticketsResource;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->authHelper->checkIfLoggedIn();

        $resultRedirect = $this->resultRedirectFactory->create();

        $request = $this->getRequest();

        if(!$this->formKeyValidator->validate($request)) {
            return $resultRedirect->setRefererUrl();
        }

        try {
            $ticket = $this->ticketsFactory->create();

            $ticket->setData([
                'customer_id' => $this->customerSession->getCustomerId(),
                'website_id' => $this->storeManager->getStore()->getWebsiteId(),
                'subject' => $request->getParam('subject'),
                'message' => $request->getParam('message'),
                'ticket_status' => 1,
                'created_at' => $this->timezone->date()
            ]);

            $this->ticketsResource->save($ticket);

            $this->_eventManager->dispatch('inchoo_support_ticket_created', ['ticket' => $ticket]);

            $this->messageManager->addSuccessMessage(__('Ticket submitted successfully'));

            return $resultRedirect->setPath('*/*/');

        } catch (\Exception $exc) {
            $this->messageManager->addErrorMessage(__('Ticket could not be created.'));
            return $resultRedirect->setPath('*/*/');
        }
    }
}