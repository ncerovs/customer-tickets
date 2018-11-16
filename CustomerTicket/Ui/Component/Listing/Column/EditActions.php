<?php

namespace Inchoo\CustomerTicket\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class EditActions extends Column
{
    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }
        foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item['ticket_id'])) {
                $item[$this->getData('name')] = [
                    'view' => [
                        'href' => $this->context->getUrl(
                            'support/tickets/ticket',
                            ['id' => $item['ticket_id']]
                        ),
                        'label' => __('View')
                    ]
                ];
            }
        }
        return $dataSource;
    }
}