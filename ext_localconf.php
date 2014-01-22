<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$signalSlotDispatcher = t3lib_div::makeInstance('Tx_Extbase_SignalSlot_Dispatcher');
$signalSlotDispatcher->connect(
	'Tx_Powermail_Controller_FormsController', 'createActionBeforeRenderView', 'Tx_WtCartOrder_Controller_OrderController', 'slotCreateActionBeforeRenderView'
);

?>