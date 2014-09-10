<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	/**
	 * Registers a Backend Module
	 */
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',
		'orderlist',
		'',
		array(
			'OrderItem' => 'list, show, generateInvoiceNumber, generateInvoiceDocument',
		),
		array(
			'access' => 'admin',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem',
		)
	);

}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Order BE Handling');

t3lib_extMgm::addLLrefForTCAdescr('tx_wtcartorder_domain_model_orderitem', 'EXT:wt_cart_order/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_orderitem.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wtcartorder_domain_model_orderitem');
$TCA['tx_wtcartorder_domain_model_orderitem'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem',
		'label' => 'order_number',
		'label_alt' => 'invoice_number',
		'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'delete' => 'deleted',
		'enablecolumns' => array(
		),
		'searchFields' => 'order_number, invoice_number',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/OrderItem.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_orderitem.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wtcartorder_domain_model_ordertax', 'EXT:wt_cart_order2/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_ordertax.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wtcartorder_domain_model_ordertax');
$TCA['tx_wtcartorder_domain_model_ordertax'] = array(
	'ctrl' => array(
		'title'    => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordertax',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'delete' => 'deleted',
		'enablecolumns' => array(
		),
		'searchFields' => 'name,value,calc,sum,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/OrderTax.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_ordertax.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wtcartorder_domain_model_orderproduct', 'EXT:wt_cart_order/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_orderproduct.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wtcartorder_domain_model_orderproduct');
$TCA['tx_wtcartorder_domain_model_orderproduct'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproduct',
		'label' => 'sku',
		'label_alt' => 'title',
		'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'delete' => 'deleted',
		'enablecolumns' => array(
		),
		'searchFields' => 'sku,title',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/OrderProduct.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_orderproduct.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wtcartorder_domain_model_orderproductadditional', 'EXT:wt_cart_order/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_orderproductadditional.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wtcartorder_domain_model_orderproductadditional');
$TCA['tx_wtcartorder_domain_model_orderproductadditional'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderproductadditional',
		'label' => 'additional_type',
		'label_alt' => 'additional_key, additional_value',
		'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'delete' => 'deleted',
		'enablecolumns' => array(
		),
		'searchFields' => 'additional_type,additional_key,additional_value',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/OrderProductAdditional.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_orderproductadditional.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wtcartorder_domain_model_ordershipping', 'EXT:wt_cart_order2/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_ordershipping.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wtcartorder_domain_model_ordershipping');
$TCA['tx_wtcartorder_domain_model_ordershipping'] = array(
	'ctrl' => array(
		'title'    => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordershipping',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'delete' => 'deleted',
		'enablecolumns' => array(
		),
		'searchFields' => 'name,value,calc,sum,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/OrderShipping.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_ordershipping.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_wtcartorder_domain_model_orderpayment', 'EXT:wt_cart_order2/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_orderpayment.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_wtcartorder_domain_model_orderpayment');
$TCA['tx_wtcartorder_domain_model_orderpayment'] = array(
	'ctrl' => array(
		'title'    => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderpayment',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'delete' => 'deleted',
		'enablecolumns' => array(
		),
		'searchFields' => 'name,value,calc,sum,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/OrderPayment.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_orderpayment.gif'
	),
);

?>