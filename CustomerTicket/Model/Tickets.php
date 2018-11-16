<?php

namespace Inchoo\CustomerTicket\Model;

use Magento\Framework\Model\AbstractModel;

class Tickets extends AbstractModel
{
    const IS_ACTIVE = 'ticket_status';

    const STATUS_ENABLED = '1';

    const STATUS_DISABLED = '0';

    public function _construct()
    {
        $this->_init(ResourceModel\Tickets::class);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Active'), self::STATUS_DISABLED => __('Closed')];
    }
}