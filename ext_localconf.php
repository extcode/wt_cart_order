<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_cart']['orderSubmitted'][] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/OrderHook.php:Extcode\WtCartOrder\Hooks\OrderHook->createOrderItemFromCart';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_cart']['afterSetOrderNumber'][] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/OrderHook.php:Extcode\WtCartOrder\Hooks\OrderHook->afterSetOrderNumber';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_cart']['afterSetInvoiceNumber'][] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/OrderHook.php:Extcode\WtCartOrder\Hooks\OrderHook->afterSetInvoiceNumber';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_cart']['beforeAddAttachmentToMail'][] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/OrderHook.php:Extcode\WtCartOrder\Hooks\OrderHook->beforeAddAttachmentToMail';

?>