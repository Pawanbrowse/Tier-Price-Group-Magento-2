<?php
/**
 * Copyright © 2015 Ocodewire. All rights reserved.
 */

namespace Ocodewire\Pricegroup\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
	
        $installer = $setup;

        $installer->startSetup();

		/**
         * Create table 'megamenu_megamenu'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('ocodewire_pricegroup_pricegroup')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )
		->addColumn(
            'price_data',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Price Tranches'
        )
        
		
		
        
        
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Ocodewire Pricegroup pricegroup_pricegroup'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/

        $installer->endSetup();

    }
}
