<?php

namespace Inchoo\TicketMailer\Observer;

use Inchoo\TicketMailer\Helper\Email;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SendMail implements ObserverInterface
{
    /**
     * @var Email
     */
    protected $helper;

    /**
     * SendMail constructor.
     * @param Email $helper
     */
    public function __construct(
        Email $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        return $this->helper->sendEmail($observer->getData('ticket'));
    }
}