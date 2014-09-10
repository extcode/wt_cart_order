<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtcartorder_domain_model_orderproductadditional'] = array(
	'ctrl' => $TCA['tx_wtcartorder_domain_model_orderproductadditional']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'additional_type, additional_key, additional_value, additional_data',
	),
	'types' => array(
		'1' => array('showitem' => 'additional_type, additional_key, additional_value, additional_data, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'additional_type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproductadditional.additional_type',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'additional_key' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproductadditional.additional_key',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'additional_value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproductadditional.additional_value',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'additional_data' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproductadditional.additional_data',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'order_product' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

?>