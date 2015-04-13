<?php

namespace Extcode\WtCartOrder\Controller;
use \TYPO3\CMS\Core\Utility as Utility;

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
 * OrderItemController
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class OrderItemController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * orderItemRepository
	 *
	 * @var \Extcode\WtCartOrder\Domain\Repository\OrderItemRepository
	 * @inject
	 */
	protected $orderItemRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
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
		$this->pageId = (int)(Utility\GeneralUtility::_GET('id')) ? Utility\GeneralUtility::_GET('id') : 1;

		$frameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
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

		$pdfRendererInstalled = Utility\ExtensionManagementUtility::isLoaded('wt_cart_pdf');
		$this->view->assign('pdfRendererInstalled', $pdfRendererInstalled);
	}

	/**
	 * action export
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

		$pdfRendererInstalled = Utility\ExtensionManagementUtility::isLoaded('wt_cart_pdf');
		$this->view->assign('pdfRendererInstalled', $pdfRendererInstalled);
	}

	/**
	 * action show
	 *
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem
	 * @return void
	 */
	public function showAction($orderItem) {
		$this->view->assign('orderItem', $orderItem);

		$pdfRendererInstalled = Utility\ExtensionManagementUtility::isLoaded('wt_cart_pdf');
		$this->view->assign('pdfRendererInstalled', $pdfRendererInstalled);
	}

	/**
	 * action edit
	 *
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem
	 * @return void
	 */
	public function editAction($orderItem) {
		$this->view->assign('orderItem', $orderItem);
	}

	/**
	 * action update
	 *
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem
	 * @return void
	 */
	public function updateAction($orderItem) {
		$this->orderItemRepository->update( $orderItem );
		$persistenceManager = Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface');
		$persistenceManager->persistAll();

		$this->redirect( 'show', NULL, NULL, array('orderItem' => $orderItem) );
	}

	/**
	 * action generateInvoiceNumber
	 *
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem
	 * @return void
	 */
	public function generateInvoiceNumberAction($orderItem) {
		if ( !$orderItem->getInvoiceNumber() ) {
			$invoiceNumber = $this->generateInvoiceNumber( $orderItem );
			$orderItem->setInvoiceNumber( $invoiceNumber );

			$this->orderItemRepository->update( $orderItem );
			$persistenceManager = Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface');
			$persistenceManager->persistAll();

			$msg = "Invoice Number " . $invoiceNumber . " was generated.";
			$this->flashMessageContainer->add( $msg );
		}

		$this->redirect('list');
	}

	/**
	 * action generateInvoiceDocument
	 *
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem
	 * @return void
	 */
	public function generateInvoiceDocumentAction($orderItem) {
		if ( !$orderItem->getInvoiceNumber() ) {
			$invoiceNumber = $this->generateInvoiceNumber( $orderItem );
			$orderItem->setInvoiceNumber( $invoiceNumber );

			$msg = "Invoice Number was generated.";
			$this->flashMessageContainer->add( $msg );
		}

		if ( $orderItem->getInvoiceNumber() ) {
			$this->generateInvoiceDocument( $orderItem );

			$this->orderItemRepository->update( $orderItem );
			$persistenceManager = Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface');
			$persistenceManager->persistAll();

			$msg = "Invoice Document was generated.";
			$this->flashMessageContainer->add( $msg );
		}

		$this->redirect('list');
	}

	/**
	 * action generateInvoiceDocument
	 *
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem
	 * @return void
	 */
	public function downloadInvoiceDocumentAction($orderItem) {
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
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem
	 * @return int
	 */
	protected function generateInvoiceNumber($orderItem) {

		$this->buildTSFE( $orderItem->getPid() );
		$wt_cart_conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_pi1.'];

		$registry =  Utility\GeneralUtility::makeInstance('t3lib_Registry');
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
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem
	 * @return int
	 */
	protected function generateInvoiceDocument($orderItem) {

		$this->buildTSFE( $orderItem->getPid() );

		$renderer = Utility\GeneralUtility::makeInstance('Tx_WtCartPdf_Utility_Renderer');

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

	/**
	 * @param int $pid
	 */
	protected function buildTSFE($pid = 1) {
		global $TYPO3_CONF_VARS;

		$GLOBALS['TSFE'] = Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController', $TYPO3_CONF_VARS, $pid, 0, true);
		$GLOBALS['TSFE']->connectToDB();
		$GLOBALS['TSFE']->fe_user = \TYPO3\CMS\Frontend\Utility\EidUtility::initFeUser();
		$GLOBALS['TSFE']->id = $pid;
		$GLOBALS['TSFE']->initTemplate();

		\TYPO3\CMS\Core\Core\Bootstrap::getInstance();

		$GLOBALS['TSFE']->cObj = Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
	}

}

?>