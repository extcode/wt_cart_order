<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtcartorder_domain_model_ordertax'] = array(
	'ctrl' => $TCA['tx_wtcartorder_domain_model_ordertax']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'tax, order_tax_class',
	),
	'types' => array(
		'1' => array('showitem' => 'tax, order_tax_class, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'tax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordertax.tax_class',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'order_tax_class' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_tax_class',
			'config' => array(
				'type' => 'select',
				'readOnly' => 1,
				'foreign_table' => 'tx_wtcartorder_domain_model_ordertaxclass',
				'minitems'      => 1,
				'maxitems'      => 1,
			),
		),
		'order_tax' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'order_total_tax' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'order_product_tax' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'order_shipping_tax' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'order_payment_tax' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

?>