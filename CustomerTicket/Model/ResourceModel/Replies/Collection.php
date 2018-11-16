<?php

namespace Inchoo\CustomerTicket\Model\ResourceModel\Replies;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            \Inchoo\CustomerTicket\Model\Replies::class,
            \Inchoo\CustomerTicket\Model\ResourceModel\Replies::class);
    }
}