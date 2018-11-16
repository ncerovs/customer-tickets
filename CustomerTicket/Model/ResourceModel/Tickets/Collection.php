<?php

namespace Inchoo\CustomerTicket\Model\ResourceModel\Tickets;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'ticket_id';

    public function _construct()
    {
        $this->_init(
            \Inchoo\CustomerTicket\Model\Tickets::class,
            \Inchoo\CustomerTicket\Model\ResourceModel\Tickets::class
        );
    }
}