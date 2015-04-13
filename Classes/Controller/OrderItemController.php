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
	 * @inject
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
	 * piVars
	 *
	 * @var array
	 */
	protected $piVars;

	/**
	 * injectOrderRepository
	 *
	 * @param Tx_WtCartOrder_Domain_Repository_OrderItemRepository $orderItemRepository
	 * @return void
	 */
	public function injectOrderItemRepository(Tx_WtCartOrder_Domain_Repository_OrderItemRepository $orderItemRepository) {
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

	public function initializeUpdateAction() {
		if ($this->request->hasArgument('orderItem')) {
			$orderItem = $this->request->getArgument('orderItem');

			$invoiceDateString = $orderItem['invoiceDate'];
			$orderItem['invoiceDate'] = DateTime::createFromFormat('d.m.Y', $invoiceDateString);

			$this->request->setArgument('orderItem', $orderItem);
		}
		$this->arguments->getArgument('orderItem')->getPropertyMappingConfiguration()->forProperty('birthday')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
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

		$this->piVars = $this->request->getArguments();
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function statisticAction() {
		$orderItems = $this->orderItemRepository->findAll( $this->piVars );

		$this->view->assign('piVars', $this->piVars);

		$statistics = array(
			'gross' => 0.0,
			'net' => 0.0,
			'orderItemCount' => count( $orderItems ),
			'orderProductCount' => 0,
		);

		foreach ( $orderItems as $orderItem ) {
			$statistics['orderItemGross'] += $orderItem->getGross();
			$statistics['orderItemNet'] += $orderItem->getNet();

			$orderProducts = $orderItem->getOrderProduct();

			if ( $orderProducts ) {
				foreach ( $orderProducts as $orderProduct ) {
					$statistics['orderProductCount'] += $orderProduct->getCount();
				}
			}
		}

		if ( $statistics['orderItemCount'] > 0 ) {
			$statistics['orderItemAverageGross'] = $statistics['orderItemGross'] / $statistics['orderItemCount'];
			$statistics['orderItemAverageNet'] = $statistics['orderItemNet'] / $statistics['orderItemCount'];
		}

		$this->view->assign('statistics', $statistics);
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$orderItems = $this->orderItemRepository->findAll( $this->piVars );

		$this->view->assign('piVars', $this->piVars);
		$this->view->assign('orderItems', $orderItems);

		$pdfRendererInstalled = t3lib_extMgm::isLoaded('wt_cart_pdf');
		$this->view->assign('pdfRendererInstalled', $pdfRendererInstalled);
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function exportAction() {
		$format = $this->request->getFormat();

		if ( $format == 'csv' ) {
			$title = "Order-Export-" . date("Y-m-d_H-i");

			$this->response->setHeader('Content-Type', 'text/' . $format, TRUE);
			$this->response->setHeader('Content-Description', 'File transfer', TRUE);
			$this->response->setHeader('Content-Disposition', 'attachment; filename="' . $title . '.' . $format . '"', TRUE);
		}

		$orderItems = $this->orderItemRepository->findAll( $this->piVars );

		$this->view->assign('piVars', $this->piVars);
		$this->view->assign('orderItems', $orderItems);

		$pdfRendererInstalled = t3lib_extMgm::isLoaded('wt_cart_pdf');
		$this->view->assign('pdfRendererInstalled', $pdfRendererInstalled);
	}

	/**
	 * action show
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return void
	 */
	public function showAction(Tx_WtCartOrder_Domain_Model_OrderItem $orderItem) {
		$this->view->assign('orderItem', $orderItem);

		$pdfRendererInstalled = t3lib_extMgm::isLoaded('wt_cart_pdf');
		$this->view->assign('pdfRendererInstalled', $pdfRendererInstalled);
	}

	/**
	 * action edit
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return void
	 */
	public function editAction(Tx_WtCartOrder_Domain_Model_OrderItem $orderItem) {
		$this->view->assign('orderItem', $orderItem);
	}

	/**
	 * action update
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return void
	 */
	public function updateAction(Tx_WtCartOrder_Domain_Model_OrderItem $orderItem) {
		$this->orderItemRepository->update( $orderItem );
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$persistenceManager->persistAll();

		$this->redirect( 'show', NULL, NULL, array('orderItem' => $orderItem) );
	}

	/**
	 * action generateInvoiceNumber
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return void
	 */
	public function generateInvoiceNumberAction(Tx_WtCartOrder_Domain_Model_OrderItem $orderItem) {
		if ( !$orderItem->getInvoiceNumber() ) {
			$invoiceNumber = $this->generateInvoiceNumber( $orderItem );
			$orderItem->setInvoiceNumber( $invoiceNumber );

			$this->orderItemRepository->update( $orderItem );
			$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
			$persistenceManager->persistAll();

			$msg = "Invoice Number " . $invoiceNumber . " was generated.";
			$this->flashMessageContainer->add( $msg );
		}

		$this->redirect('list');
	}

	/**
	 * action generateInvoiceDocument
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return void
	 */
	public function generateInvoiceDocumentAction(Tx_WtCartOrder_Domain_Model_OrderItem $orderItem) {
		if ( !$orderItem->getInvoiceNumber() ) {
			$invoiceNumber = $this->generateInvoiceNumber( $orderItem );
			$orderItem->setInvoiceNumber( $invoiceNumber );

			$msg = "Invoice Number was generated.";
			$this->flashMessageContainer->add( $msg );
		}

		if ( $orderItem->getInvoiceNumber() ) {
			$this->generateInvoiceDocument( $orderItem );

			$this->orderItemRepository->update( $orderItem );
			$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
			$persistenceManager->persistAll();

			$msg = "Invoice Document was generated.";
			$this->flashMessageContainer->add( $msg );
		}

		$this->redirect('list');
	}

	/**
	 * action generateInvoiceDocument
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return void
	 */
	public function downloadInvoiceDocumentAction(Tx_WtCartOrder_Domain_Model_OrderItem $orderItem) {
		$file = PATH_site . $orderItem->getInvoicePdf();
		$fileName = 'Invoice.pdf';

		if ( is_file( $file ) ) {

			$fileLen    = filesize($file);

			$headers = array(
				'Pragma'                    => 'public',
				'Expires'                   => 0,
				'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
				'Cache-Control'             => 'public',
				'Content-Description'       => 'File Transfer',
				'Content-Type'              => 'application/pdf',
				'Content-Disposition'       => 'attachment; filename="'. $fileName .'"',
				'Content-Transfer-Encoding' => 'binary',
				'Content-Length'            => $fileLen
			);

			foreach($headers as $header => $data)
				$this->response->setHeader($header, $data);

			$this->response->sendHeaders();
			@readfile($file);
		}
		exit;

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

	/**
	 * generateInvoiceNumber
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 * @return int
	 */
	protected function generateInvoiceDocument( $orderItem ) {

		$this->buildTSFE( $orderItem->getPid() );

		$renderer = t3lib_div::makeInstance('Tx_WtCartPdf_Utility_Renderer');

		$files = array();
		$errors = array();

		$params = array(
			'orderItem' => $orderItem,
			'type' => 'invoice',
			'files' => &$files,
			'errors' => &$errors
		);

		$renderer->createPdf( $params );

		if ( $params['files']['invoice'] ) {
			$orderItem->setInvoicePdf( $params['files']['invoice'] );
		}
	}

}

?>