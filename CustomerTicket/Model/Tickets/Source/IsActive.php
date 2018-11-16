<?php

namespace Inchoo\CustomerTicket\Model\Tickets\Source;

use Magento\Framework\Data\OptionSourceInterface;

class IsActive implements OptionSourceInterface
{
    /**
     * @var \Inchoo\CustomerTicket\Model\Tickets
     */
    protected $ticket;

    /**
     * IsActive constructor.
     * @param \Inchoo\CustomerTicket\Model\Tickets $ticket
     */
    public function __construct(
        \Inchoo\CustomerTicket\Model\Tickets $ticket
    ) {
        $this->ticket = $ticket;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->ticket->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
