<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtcartorder_domain_model_orderitem'] = array(
	'ctrl' => $TCA['tx_wtcartorder_domain_model_orderitem']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'pid, fe_user, order_number, invoice_number, first_name, last_name, email, shipping_address, payment_address, gross, net, total_gross, total_net, additional_data, order_product, order_tax, order_total_tax, order_payment, order_shipping, order_pdf, invoice_pdf',
	),
	'types' => array(
		'1' => array('showitem' =>
			'pid, fe_user,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.numbers;numbers,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.purchaser;purchaser,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.addresses;addresses,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.price;price,
			--palette--;LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.palettes.total_price;total_price,
			additional_data,
			order_product,
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
		'numbers' => array('showitem' => 'order_number, order_date, --linebreak--, invoice_number, invoice_date', 'canNotCollapse' => 1),
		'price' => array('showitem' => 'gross, net, --linebreak--, order_tax', 'canNotCollapse' => 1),
		'total_price' => array('showitem' => 'total_gross, total_net, --linebreak--, order_total_tax', 'canNotCollapse' => 1),
	),
	'columns' => array(
		'pid' => array(
			'exclude' => 1,
			'config' => array(
				'type' => 'passthrough'
			)
		),
		'fe_user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.fe_user',
			'config' => array(
				'type' => 'select',
				'readOnly' => 1,
				'foreign_table' => 'fe_users',
				'size' => 1,
				'autoMaxSize' => 1,
				'minitems' => 0,
				'maxitems' => 1,
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
				'eval' => 'trim'
			),
		),
		'order_date' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_date',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0'
			)
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
		'invoice_date' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.invoice_date',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0'
			)
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
		'additional_data' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.additional_data',
			'config' => array(
				'type' => 'text',
				'readOnly' => 1,
				'cols' => 48,
				'rows' => 15
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
		'total_gross' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.total_gross',
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
		'total_net' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.total_net',
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
				'foreign_field' => 'order_item_tax',
				'maxitems'      => 9999,
			),
		),
		'order_total_tax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_total_tax',
			'config' => array(
				'type' => 'inline',
				'readOnly' => 1,
				'foreign_table' => 'tx_wtcartorder_domain_model_ordertax',
				'foreign_field' => 'order_item_total_tax',
				'maxitems'      => 9999,
			),
		),
		'order_product' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem.order_product',
			'config' => array(
				'type' => 'inline',
				'readOnly' => 1,
				'foreign_table' => 'tx_wtcartorder_domain_model_orderproduct',
				'foreign_field' => 'order_item',
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
		'crdate' => Array (
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0'
			)
		),
	),
);

?>