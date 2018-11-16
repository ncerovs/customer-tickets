<?php

namespace Inchoo\CustomerTicket\Helper;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class AuthHelper extends AbstractHelper
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * AuthHelper constructor.
     * @param Context $context
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
        $this->urlBuilder = $context->getUrlBuilder();
        parent::__construct($context);
    }

    /**
     * redirect if not logged in
     */
    public function checkIfLoggedIn()
    {
        if(!$this->customerSession->authenticate()) {
            $this->customerSession->setAfterAuthUrl($this->urlBuilder->getCurrentUrl());
            $this->customerSession->authenticate();
        }
    }
}