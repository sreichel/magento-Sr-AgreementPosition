<?php

/** @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer = $this;
$installer->startSetup();

if (version_compare(Mage::getVersion(), '1.6', '<')) {
    $installer->run("
        ALTER TABLE `{$installer->getTable('checkout/agreement')}`
        ADD `position` SMALLINT( 2 ) NOT NULL COMMENT 'Agreement Position'
    ");

} else {
    $installer->getConnection()->addColumn(
        $installer->getTable('checkout/agreement'),
        'position',
        array(
            'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'length'    => 2,
            'nullable'  => false,
            'default'   => 0,
            'comment'   => 'Agreement Position'
        )
    );
}

$installer->endSetup();
