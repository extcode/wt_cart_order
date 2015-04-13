<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtcartorder_domain_model_ordershipping'] = array(
	'ctrl' => $TCA['tx_wtcartorder_domain_model_ordershipping']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, status, gross, net, order_tax, note',
	),
	'types' => array(
		'1' => array('showitem' => 'name, status, gross, net, order_tax, note'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.name',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.status',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.status.open', 'open'),
					array('LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.status.on_hold', 'on_hold'),
					array('LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.status.in_process', 'in_process'),
					array('LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.status.shipped', 'shipped')
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required'
			),
		),
		'gross' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.gross',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'net' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.net',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2'
			),
		),
		'order_tax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.order_tax',
			'config' => array(
				'type' => 'inline',
				'readOnly' => 1,
				'foreign_table' => 'tx_wtcartorder_domain_model_ordertax',
				'foreign_field' => 'order_shipping_tax',
				'minitems'      => 1,
				'maxitems'      => 1,
			),
		),
		'note' => array(
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping.note',
			'config' => array(
				'type' => 'text',
				'readOnly' => 1,
				'cols' => '40',
				'rows' => '15'
			)
		),
	),
);

?>