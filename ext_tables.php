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
		'web',	 // Make module a submodule of 'web'
		'orderlist',	// Submodule key
		'',						// Position
		array(
			'Order' => 'list, show',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_orderlist.xml',
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
		'searchFields' => 'order_number',
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

?>