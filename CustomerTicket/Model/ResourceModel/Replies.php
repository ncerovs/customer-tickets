<?php

namespace Inchoo\CustomerTicket\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Replies extends AbstractDb
{
    public function _construct()
    {
        $this->_init('inchoo_tickets_replies', 'reply_id');
    }
}