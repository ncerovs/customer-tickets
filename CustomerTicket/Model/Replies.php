<?php

namespace Inchoo\CustomerTicket\Model;

use Magento\Framework\Model\AbstractModel;

class Replies extends AbstractModel
{
    public function _construct()
    {
        $this->_init(ResourceModel\Replies::class);
    }
}