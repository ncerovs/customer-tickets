<?php

namespace Inchoo\CustomerTicket\Ui\Component\Listing;

use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var
     */
    protected $ticketCollectionFactory;

    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param \Inchoo\CustomerTicket\Model\ResourceModel\Tickets\CollectionFactory $ticketCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\CustomerTicket\Model\ResourceModel\Tickets\CollectionFactory $ticketCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $ticketCollectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = $this->getCustomerData($this->collection);

        return $data;
    }

    /**
     * @param $collection
     * @return mixed
     */
    public function getCustomerData($collection)
    {
        $collection->getSelect()->joinLeft(
            ['customer' => 'customer_entity'],
            'main_table.customer_id = customer.entity_id',
            ['customer_first_name' => 'customer.firstname', 'customer_last_name' => 'customer.lastname']
        );

        return $collection->toArray();
    }
}