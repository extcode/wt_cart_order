<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Extcode.' . $_EXTKEY,
		'web',
		'OrderList',
		'',
		array(
			'OrderItem' => 'list, export, show, edit, update, statistic, generateInvoiceNumber, generateInvoiceDocument, downloadInvoiceDocument',
		),
		array(
			'access' => 'user, group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_orderitem',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'wt_cart_order - Example Configuration');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wtcartorder_domain_model_orderitem', 'EXT:wt_cart_order/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_orderitem.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wtcartorder_domain_model_orderitem');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/OrderItem.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_orderitem.png'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wtcartorder_domain_model_ordertaxclass', 'EXT:wt_cart_order2/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_ordertaxclass.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wtcartorder_domain_model_ordertaxclass');
$TCA['tx_wtcartorder_domain_model_ordertaxclass'] = array(
	'ctrl' => array(
		'title'    => 'LLL:EXT:wt_cart_order/Resources/Private/Language/locallang_db.xml:tx_wtcartorder_domain_model_ordertaxclass',
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
		'searchFields' => 'name,value,calc',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/OrderTaxClass.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_ordertax.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wtcartorder_domain_model_ordertax', 'EXT:wt_cart_order2/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_ordertax.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wtcartorder_domain_model_ordertax');
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
		'searchFields' => '',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/OrderTax.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_ordertax.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wtcartorder_domain_model_orderproduct', 'EXT:wt_cart_order/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_orderproduct.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wtcartorder_domain_model_orderproduct');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/OrderProduct.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_orderproduct.png'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wtcartorder_domain_model_orderproductadditional', 'EXT:wt_cart_order/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_orderproductadditional.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wtcartorder_domain_model_orderproductadditional');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/OrderProductAdditional.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_orderproductadditional.png'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wtcartorder_domain_model_ordershipping', 'EXT:wt_cart_order2/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_ordershipping.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wtcartorder_domain_model_ordershipping');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/OrderShipping.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_ordershipping.png'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wtcartorder_domain_model_orderpayment', 'EXT:wt_cart_order2/Resources/Private/Language/locallang_csh_tx_wtcartorder_domain_model_orderpayment.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wtcartorder_domain_model_orderpayment');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/OrderPayment.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtcartorder_domain_model_orderpayment.png'
	),
);

?>