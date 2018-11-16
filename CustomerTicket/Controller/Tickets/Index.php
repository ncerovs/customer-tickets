<?php

namespace Inchoo\CustomerTicket\Controller\Tickets;

use Inchoo\CustomerTicket\Helper\AuthHelper;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $authHelper;

    public function __construct(
        Context $context,
        AuthHelper $authHelper
    ) {
        $this->authHelper = $authHelper;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->authHelper->checkIfLoggedIn();

        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
}