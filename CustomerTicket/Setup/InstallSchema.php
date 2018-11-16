<?php

namespace Inchoo\CustomerTicket\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable('inchoo_tickets')
        )->addColumn(
            'ticket_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Ticket Id'
        )->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Customer Id'
        )->addColumn(
            'website_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Store Id'
        )->addColumn(
            'subject',
            Table::TYPE_TEXT,
            255,
            [],
            'Ticket Subject'
        )->addColumn(
            'message',
            Table::TYPE_TEXT,
            null,
            [],
            'Ticket Message'
        )->addColumn(
            'ticket_status',
            Table::TYPE_BOOLEAN,
            null,
            ['default' => '1'],
            'Ticket Status'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => 'false'],
            'Created at'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => 'false'],
            'Updated at'
        )->setComment(
            'Tickets Table'
        )->addIndex(
            $setup->getIdxName('inchoo_tickets', ['customer_id']),
            ['customer_id']
        )->addForeignKey(
            $setup->getFkName(
                'inchoo_tickets',
                'customer_id',
                'customer_entity',
                'entity_id'
            ),
            'customer_id',
            $setup->getTable('customer_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        );
        $setup->getConnection()->createTable($table);

        $table = $setup->getConnection()->newTable(
            $setup->getTable('inchoo_tickets_replies')
        )->addColumn(
            'reply_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Reply Id'
        )->addColumn(
            'ticket_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Ticket Id'
        )->addColumn(
            'is_admin',
            Table::TYPE_BOOLEAN,
            null,
            ['nullable' => false],
            'Store Id'
        )->addColumn(
            'message',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Ticket Message'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => 'false'],
            'Created at'
        )->setComment(
            'Tickets Replies'
        )->addIndex(
            $setup->getIdxName('inchoo_tickets_replies', ['ticket_id']),
            ['ticket_id']
        )->addForeignKey(
            $setup->getFkName(
                'inchoo_tickets_replies',
                'ticket_id',
                'inchoo_tickets',
                'ticket_id'
            ),
            'ticket_id',
            $setup->getTable('inchoo_tickets'),
            'ticket_id',
            Table::ACTION_CASCADE
        );
        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}