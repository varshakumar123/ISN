<?php
namespace ISN\CheckBox\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;
		$installer->startSetup();
		if(version_compare($context->getVersion(), '4.1.1', '<')) {
			$installer->getConnection()->addColumn(
				$installer->getTable( 'quote' ),
				'checkBoxValue',
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'nullable' => true,
					'length' => '12,4',
					'comment' => 'custom_checkbox_value'
				]
			);
		}
		$installer->endSetup();
	}
}