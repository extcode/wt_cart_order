<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_cart']['orderSubmitted'][] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/OrderHook.php:Tx_WtCartOrder_Hooks_OrderHook->createOrderItemFromCart';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_cart']['afterSetOrderNumber'][] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/OrderHook.php:Tx_WtCartOrder_Hooks_OrderHook->afterSetOrderNumber';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_cart']['afterSetInvoiceNumber'][] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/OrderHook.php:Tx_WtCartOrder_Hooks_OrderHook->afterSetInvoiceNumber';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_cart']['beforeAddAttachmentToMail'][] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/OrderHook.php:Tx_WtCartOrder_Hooks_OrderHook->beforeAddAttachmentToMail';

?>