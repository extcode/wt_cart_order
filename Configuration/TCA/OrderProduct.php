<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtcartorder_domain_model_orderproduct'] = array(
	'ctrl' => $TCA['tx_wtcartorder_domain_model_orderproduct']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sku, title, count, additional_data, order_product_additional, price, discount, gross, net, tax',
	),
	'types' => array(
		'1' => array('showitem' => 'sku, title, count, --palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.price.group;price, order_product_additional, additional_data, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
		'price' => array('showitem' => 'price, discount, --linebreak--, gross, net, --linebreak--, order_tax', 'canNotCollapse' => 1),
	),
	'columns' => array(
		'sku' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.sku',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.title',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'count' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.count',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'int'
			),
		),
		'price' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.price',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'discount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.discount',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'gross' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.gross',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'net' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.net',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'order_tax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.order_tax',
			'config' => array(
				'type' => 'inline',
				'readOnly' => 1,
				'foreign_table' => 'tx_wtcartorder_domain_model_ordertax',
				'foreign_field' => 'order_product_tax',
				'minitems'      => 1,
				'maxitems'      => 1,
			),
		),
		'additional_data' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.additional_data',
			'config' => array(
				'type' => 'text',
				'readOnly' => 1,
				'cols' => 48,
				'rows' => 5
			),
		),
		'order_item' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'order_product_additional' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct.order_product_additional',
			'config' => array(
				'type' => 'inline',
				'readOnly' => 1,
				'foreign_table' => 'tx_wtcartorder_domain_model_orderproductadditional',
				'foreign_field' => 'order_product',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
	),
);

?>