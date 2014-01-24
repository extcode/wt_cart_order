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
class Tx_WtCartOrder_Domain_Model_OrderItem extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * feUser
	 *
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 */
	protected $feUser;

	/**
	 * orderNumber
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $orderNumber;

	/**
	 * invoiceNumber
	 *
	 * @var string
	 */
	protected $invoiceNumber;

	/**
	 * gross
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $gross;

	/**
	 * net
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $net;

	/**
	 * orderTax
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderTax>
	 */
	protected $orderTax;

	/**
	 * orderProduct
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderProduct>
	 */
	protected $orderProduct;

	/**
	 * orderPayment
	 *
	 * @var Tx_Test_Domain_Model_OrderPayment
	 */
	protected $orderPayment;

	/**
	 * orderShipping
	 *
	 * @var Tx_Test_Domain_Model_OrderShipping
	 */
	protected $orderShipping;

	/**
	 * orderPdf
	 *
	 * @var string
	 */
	protected $orderPdf;

	/**
	 * invoicePdf
	 *
	 * @var string
	 */
	protected $invoicePdf;

	/**
	 * __construct
	 *
	 * @return \Tx_WtCartOrder_Domain_Model_OrderItem
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->orderProduct = new Tx_Extbase_Persistence_ObjectStorage();
		$this->orderTax = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * @param \Tx_Extbase_Domain_Model_FrontendUser $feUser
	 * @return void
	 */
	public function setFeUser($feUser) {
		$this->feUser = $feUser;
	}

	/**
	 * @return \Tx_Extbase_Domain_Model_FrontendUser
	 */
	public function getFeUser() {
		return $this->feUser;
	}

	/**
	 * Returns the orderNumber
	 *
	 * @return string $orderNumber
	 */
	public function getOrderNumber() {
		return $this->orderNumber;
	}

	/**
	 * Sets the orderNumber
	 *
	 * @param string $orderNumber
	 * @return void
	 */
	public function setOrderNumber($orderNumber) {
		$this->orderNumber = $orderNumber;
	}

	/**
	 * Sets the invoiceNumber
	 *
	 * @param string $invoiceNumber
	 * @return void
	 */
	public function setInvoiceNumber($invoiceNumber) {
		$this->invoiceNumber = $invoiceNumber;
	}

	/**
	 * Returns the invoiceNumber
	 *
	 * @return string
	 */
	public function getInvoiceNumber() {
		return $this->invoiceNumber;
	}

	/**
	 * Returns the gross
	 *
	 * @return float $gross
	 */
	public function getGross() {
		return $this->gross;
	}

	/**
	 * Sets the gross
	 *
	 * @param float $gross
	 * @return void
	 */
	public function setGross($gross) {
		$this->gross = $gross;
	}

	/**
	 * Returns the net
	 *
	 * @return float $net
	 */
	public function getNet() {
		return $this->net;
	}

	/**
	 * Sets the net
	 *
	 * @param float $net
	 * @return void
	 */
	public function setNet($net) {
		$this->net = $net;
	}

	/**
	 * @param Tx_WtCartOrder_Domain_Model_OrderPayment $orderPayment
	 * @return void
	 */
	public function setOrderPayment($orderPayment) {
		$this->orderPayment = $orderPayment;
	}

	/**
	 * @return Tx_WtCartOrder_Domain_Model_OrderPayment
	 */
	public function getOrderPayment() {
		return $this->orderPayment;
	}

	/**
	 * @param Tx_WtCartOrder_Domain_Model_OrderShipping $orderShipping
	 * @return void
	 */
	public function setOrderShipping($orderShipping) {
		$this->orderShipping = $orderShipping;
	}

	/**
	 * @return Tx_WtCartOrder_Domain_Model_OrderShipping
	 */
	public function getOrderShipping() {
		return $this->orderShipping;
	}

	/**
	 * Returns the orderPdf
	 *
	 * @return string $orderPdf
	 */
	public function getOrderPdf() {
		return $this->orderPdf;
	}

	/**
	 * Sets the orderPdf
	 *
	 * @param string $orderPdf
	 * @return void
	 */
	public function setOrderPdf($orderPdf) {
		$this->orderPdf = $orderPdf;
	}

	/**
	 * @return string
	 */
	public function getInvoicePdf() {
		return $this->invoicePdf;
	}

	/**
	 * @param string $invoicePdf
	 * @return void
	 */
	public function setInvoicePdf($invoicePdf) {
		$this->invoicePdf = $invoicePdf;
	}

	/**
	 * Adds a OrderProduct
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderProduct $orderProduct
	 * @return void
	 */
	public function addOrderProduct(Tx_WtCartOrder_Domain_Model_OrderProduct $orderProduct) {
		$this->orderProduct->attach($orderProduct);
	}

	/**
	 * Removes a OrderProduct
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderProduct $orderProductToRemove The OrderProduct to be removed
	 * @return void
	 */
	public function removeOrderProduct(Tx_WtCartOrder_Domain_Model_OrderProduct $orderProductToRemove) {
		$this->orderProduct->detach($orderProductToRemove);
	}

	/**
	 * Returns the orderProduct
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderProduct> $orderProduct
	 */
	public function getOrderProduct() {
		return $this->orderProduct;
	}

	/**
	 * Sets the orderProduct
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderProduct> $orderProduct
	 * @return void
	 */
	public function setOrderProduct(Tx_Extbase_Persistence_ObjectStorage $orderProduct) {
		$this->orderProduct = $orderProduct;
	}

	/**
	 * Adds a OrderTax
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderTax $orderTax
	 * @return void
	 */
	public function addOrderTax(Tx_WtCartOrder_Domain_Model_OrderTax $orderTax) {
		$this->orderTax->attach($orderTax);
	}

	/**
	 * Removes a OrderTax
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderTax $orderTaxToRemove The OrderTax to be removed
	 * @return void
	 */
	public function removeOrderTax(Tx_WtCartOrder_Domain_Model_OrderTax $orderTaxToRemove) {
		$this->orderTax->detach($orderTaxToRemove);
	}

	/**
	 * Returns the orderTax
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderTax> $orderTax
	 */
	public function getOrderTax() {
		return $this->orderTax;
	}

	/**
	 * Sets the orderTax
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderTax> $orderTax
	 * @return void
	 */
	public function setOrderTax(Tx_Extbase_Persistence_ObjectStorage $orderTax) {
		$this->orderTax = $orderTax;
	}

}

?>