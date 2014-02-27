<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtcartorder_domain_model_orderitem'] = array(
	'ctrl' => $TCA['tx_wtcartorder_domain_model_orderitem']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'fe_user, order_number, invoice_number, first_name, last_name, email, shipping_address, payment_address, gross, net, order_product, order_tax, order_payment, order_shipping, order_pdf, invoice_pdf',
	),
	'types' => array(
		'1' => array('showitem' =>
			'fe_user,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.numbers;numbers,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.purchaser;purchaser,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.addresses;addresses,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.price;price,
			order_product,
			order_tax,
			order_payment,
			order_shipping,
			order_pdf,
			invoice_pdf'
		),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
		'purchaser' => array('showitem' => 'first_name, last_name, email', 'canNotCollapse' => 1),
		'addresses' => array('showitem' => 'shipping_address, billing_address', 'canNotCollapse' => 0),
		'numbers' => array('showitem' => 'order_number, invoice_number', 'canNotCollapse' => 1),
		'price' => array('showitem' => 'gross, net', 'canNotCollapse' => 1),
	),
	'columns' => array(
		'fe_user' => Array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.fe_user',
			'config' => Array(
				'type' => 'select',
				'readOnly' => 1,
				'foreign_table' => 'fe_users',
				'size' => 1,
				'autoMaxSize' => 10,
				'maxitems' => 9999,
				'multiple' => 0,
			)
		),
		'order_number' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_number',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'invoice_number' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.invoice_number',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'first_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.first_name',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'last_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.last_name',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.email',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'billing_address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.billing_address',
			'config' => array(
				'type' => 'text',
				'cols' => 48,
				'rows' => 15,
				'eval' => 'required'
			),
		),
		'shipping_address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.shipping_address',
			'config' => array(
				'type' => 'text',
				'cols' => 48,
				'rows' => 15,
				'eval' => 'required'
			),
		),
		'description1' => array(
			'exclude' => 0,
			'defaultExtras' => 'richtext[*]',
			'label' => 'LLL:EXT:wt_cart_event/Resources/Private/Language/locallang_db.xml:tx_wtcartevent_domain_model_event.description1',
			'config' => array(
				'type' => 'text',
				'cols' => 48,
				'rows' => 15,
				'eval' => 'required',
				'wizards' => array(
					'_PADDING' => 4,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php'
					)
				)
			),
		),
		'gross' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.gross',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2,required'
			),
		),
		'net' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.net',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2,required'
			),
		),
		'order_tax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_tax',
			'config' => array(
				'type' => 'inline',
				'readOnly' => 1,
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
				'readOnly' => 1,
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
				'readOnly' => 1,
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
				'readOnly' => 1,
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
				'readOnly' => 1,
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
				'readOnly' => 1,
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