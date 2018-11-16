<?php

namespace Inchoo\CustomerTicket\Controller\Replies;

use Inchoo\CustomerTicket\Helper\AuthHelper;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class AddReply extends Action
{
    protected $formKeyValidator;

    protected $customerSession;

    protected $timezone;

    protected $repliesFactory;

    protected $repliesResource;

    protected $authHelper;

    public function __construct(
        Context $context,
        Validator $formKeyValidator,
        Session $customerSession,
        TimezoneInterface $timezone,
        \Inchoo\CustomerTicket\Model\RepliesFactory $repliesFactory,
        \Inchoo\CustomerTicket\Model\ResourceModel\Replies $repliesResource,
        AuthHelper $authHelper
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->timezone = $timezone;
        $this->repliesFactory = $repliesFactory;
        $this->repliesResource = $repliesResource;
        $this->authHelper = $authHelper;
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

        if($request->isPost()) {
            $reply = $this->repliesFactory->create();

            $reply->setData([
                'ticket_id' => $request->getParam('ticket_id'),
                'is_admin' => 0,
                'message' => $request->getParam('reply'),
                'created_at' => $this->timezone->date()
            ]);

            $this->repliesResource->save($reply);

            $this->messageManager->addSuccessMessage(__('Reply submitted'));

            return $resultRedirect->setRefererUrl();
        }

        $this->messageManager->addErrorMessage(__('An unknown error has occurred'));

        return $resultRedirect->setRefererUrl();

    }
}