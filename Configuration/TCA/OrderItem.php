<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtcartorder_domain_model_orderitem'] = array(
	'ctrl' => $TCA['tx_wtcartorder_domain_model_orderitem']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'order_number, invoice_number, gross, net, order_product, order_tax, order_payment, order_shipping, order_pdf, invoice_pdf',
	),
	'types' => array(
		'1' => array('showitem' => '--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.numbers;numbers, --palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.price;price, order_product, order_tax, order_payment, order_shipping, order_pdf, invoice_pdf'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
		'numbers' => array('showitem' => 'order_number, invoice_number', 'canNotCollapse' => 1),
		'price' => array('showitem' => 'gross, net', 'canNotCollapse' => 1),
	),
	'columns' => array(
		'order_number' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_number',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'invoice_number' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.invoice_number',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'gross' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.gross',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2,required'
			),
		),
		'net' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.net',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2,required'
			),
		),
		'order_tax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_tax',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wtcartorder_domain_model_ordertax',
				'foreign_field' => 'orderitem',
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
		'order_product' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_product',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wtcartorder_domain_model_orderproduct',
				'foreign_field' => 'orderitem',
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
		'order_payment' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_payment',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wtcartorder_domain_model_orderpayment',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'order_shipping' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_shipping',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_wtcartorder_domain_model_ordershipping',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'order_pdf' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_pdf',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'uploadfolder' => 'uploads/tx_wtcartorder/order_pdf/',
				'allowed' => 'pdf',
				'disallowed' => 'php',
				'size' => 1,
				'maxitems' => 0,
				'maxitems' => 1,
			),
		),
		'invoice_pdf' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.invoice_pdf',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'uploadfolder' => 'uploads/tx_wtcartorder/invoice_pdf/',
				'allowed' => 'pdf',
				'disallowed' => 'php',
				'size' => 1,
				'maxItems' => 0,
				'maxItems' => 1,
			),
		),
	),
);

?>