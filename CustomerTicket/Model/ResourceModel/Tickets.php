<?php

namespace Inchoo\CustomerTicket\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Tickets extends AbstractDb
{
    public function _construct()
    {
        $this->_init('inchoo_tickets', 'ticket_id');
    }
}