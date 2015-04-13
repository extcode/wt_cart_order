<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtcartorder_domain_model_ordertaxclass'] = array(
	'ctrl' => $TCA['tx_wtcartorder_domain_model_ordertaxclass']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name, value, calc',
	),
	'types' => array(
		'1' => array('showitem' => 'name, value, calc,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordertaxclass.name',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'value' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordertaxclass.value',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'calc' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordertaxclass.calc',
			'config' => array(
				'type' => 'input',
				'readOnly' => 1,
				'size' => 30,
				'eval' => 'double2'
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
	),
);

?>