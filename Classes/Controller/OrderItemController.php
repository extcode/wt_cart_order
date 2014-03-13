<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Daniel Lorenz <wt_cart_order@extco.de>, extco.de UG (haftungsbeschränkt)
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once(PATH_tslib.'class.tslib_fe.php');
require_once(PATH_t3lib.'class.t3lib_userauth.php');
require_once(PATH_tslib.'class.tslib_feuserauth.php');
require_once(PATH_t3lib.'class.t3lib_cs.php');
require_once(PATH_tslib.'class.tslib_content.php');
require_once(PATH_t3lib.'class.t3lib_tstemplate.php');
require_once(PATH_t3lib.'class.t3lib_page.php');

/**
 *
 *
 * @package wt_cart_order
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_WtCartOrder_Controller_OrderItemController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * orderItemRepository
	 *
	 * @var Tx_WtCartOrder_Domain_Repository_OrderItemRepository
	 */
	protected $orderItemRepository;

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * @var int Current page
	 */
	protected $pageId;

	/**
	 * injectOrderRepository
	 *
	 * @param Tx_WtCartOrder_Domain_Repository_OrderItemRepository $orderItemRepository
	 * @return void
	 */
	public function injectEventRepository(Tx_WtCartOrder_Domain_Repository_OrderItemRepository $orderItemRepository) {
		$this->orderItemRepository = $orderItemRepository;
	}

	/**
	 * @param int $pid
	 */
	public function buildTSFE($pid = 1) {
		if (!is_object($GLOBALS['TT'])) {
			$GLOBALS['TT'] = new t3lib_timeTrack;
			$GLOBALS['TT']->start();
		}

		$GLOBALS['TSFE'] = t3lib_div::makeInstance('tslib_fe', $GLOBALS['TYPO3_CONF_VARS'], $pid, '0', 1, '', '', '', '');

		//*** Builds sub objects
		$GLOBALS['TSFE']->tmpl = t3lib_div::makeInstance('t3lib_tsparser_ext');
		$GLOBALS['TSFE']->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');

		//*** init template
		$GLOBALS['TSFE']->tmpl->tt_track = 0;
		$GLOBALS['TSFE']->tmpl->init();

		$rootLine = $GLOBALS['TSFE']->sys_page->getRootLine($pid);

		//*** This generates the constants/config + hierarchy info for the template.
		$GLOBALS['TSFE']->tmpl->runThroughTemplates($rootLine, $template_uid);
		$GLOBALS['TSFE']->tmpl->generateConfig();
		$GLOBALS['TSFE']->tmpl->loaded=1;

		//*** Get config array and other init from pagegen
		$GLOBALS['TSFE']->getConfigArray();

		//*** Builds a cObj
		$GLOBALS['TSFE']->newCObj();
	}


	/**
	 * Action initializer
	 *
	 * @return void
	 */
	protected function initializeAction() {
		$this->pageId = (int)t3lib_div::_GP('id');

		$frameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$persistenceConfiguration = array('persistence' => array('storagePid' => $this->pageId));
		$this->configurationManager->setConfiguration(array_merge($frameworkConfiguration, $persistenceConfiguration));
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$orderItems = $this->orderItemRepository->findAll();
		$this->view->assign('orderItems', $orderItems);
	}

	/**
	 * action show
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return void
	 */
	public function showAction(Tx_WtCartOrder_Domain_Model_OrderItem $orderItem) {
		$this->view->assign('orderItem', $orderItem);
	}

	/**
	 * action makeInvoice
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return void
	 */
	public function makeInvoiceAction(Tx_WtCartOrder_Domain_Model_OrderItem $orderItem) {
		if ( !$orderItem->getInvoiceNumber() ) {
			$invoiceNumber = $this->generateInvoiceNumber( $orderItem );
			$orderItem->setInvoiceNumber( $invoiceNumber );

			$msg = "Invoice Number " . $invoiceNumber . " was generated.";
			$this->flashMessageContainer->add( $msg );
		}

		$this->redirect('list');
	}

	/**
	 * generateInvoiceNumber
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return int
	 */
	protected function generateInvoiceNumber( $orderItem ) {

		$this->buildTSFE( $orderItem->getPid() );
		$wt_cart_conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_pi1.'];

		$registry =  t3lib_div::makeInstance('t3lib_Registry');
		$invoiceNumber =  $registry->get( 'tx_wtcart', 'lastInvoice_' . $wt_cart_conf['main.']['pid'] );
		if ( $invoiceNumber ) {
			$invoiceNumber += 1;
		} else {
			$invoiceNumber = 1;
		}
		$registry->set('tx_wtcart', 'lastInvoice_' . $wt_cart_conf['main.']['pid'],  $invoiceNumber);

		$invoiceNumberConf = $wt_cart_conf['settings.']['fields.'];
		$GLOBALS['TSFE']->cObj->start( array( 'invoicenumber' => $invoiceNumber ), $invoiceNumberConf['invoicenumber'] );
		$invoiceNumber = $GLOBALS['TSFE']->cObj->cObjGetSingle( $invoiceNumberConf['invoicenumber'], $invoiceNumberConf['invoicenumber.'] );

		return $invoiceNumber;
	}

}

?>