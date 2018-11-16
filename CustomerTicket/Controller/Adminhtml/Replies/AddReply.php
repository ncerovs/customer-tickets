<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Replies;

use Magento\Backend\App\Action;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class AddReply extends Action
{
    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var
     */
    protected $customerSession;

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * @var \Inchoo\CustomerTicket\Model\RepliesFactory
     */
    protected $repliesFactory;

    /**
     * @var \Inchoo\CustomerTicket\Model\ResourceModel\Replies
     */
    protected $repliesResource;

    /**
     * @var
     */
    protected $authHelper;

    /**
     * AddReply constructor.
     * @param Action\Context $context
     * @param Validator $formKeyValidator
     * @param TimezoneInterface $timezone
     * @param \Inchoo\CustomerTicket\Model\RepliesFactory $repliesFactory
     * @param \Inchoo\CustomerTicket\Model\ResourceModel\Replies $repliesResource
     */
    public function __construct(
        Action\Context $context,
        Validator $formKeyValidator,
        TimezoneInterface $timezone,
        \Inchoo\CustomerTicket\Model\RepliesFactory $repliesFactory,
        \Inchoo\CustomerTicket\Model\ResourceModel\Replies $repliesResource
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->timezone = $timezone;
        $this->repliesFactory = $repliesFactory;
        $this->repliesResource = $repliesResource;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $request = $this->getRequest();

        if($request->isPost()) {
            $reply = $this->repliesFactory->create();

            $reply->setData([
                'ticket_id' => $request->getParam('ticket_id'),
                'is_admin' => 1,
                'message' => $request->getParam('reply'),
                'created_at' => $this->timezone->date()
            ]);

            $this->repliesResource->save($reply);

            $this->messageManager->addSuccessMessage(__('Reply submitted'));

            return $resultRedirect->setRefererUrl();
        }

        $this->messageManager->addErrorMessage(__('Reply submit failed'));

        return $resultRedirect->setRefererUrl();

    }
}