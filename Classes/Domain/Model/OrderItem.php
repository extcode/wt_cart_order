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
	 * paymentName
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $paymentName;

	/**
	 * paymentId
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $paymentId;

	/**
	 * paymentStatus
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $paymentStatus;

	/**
	 * shippingName
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $shippingName;

	/**
	 * shippingId
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $shippingId;

	/**
	 * shippingStatus
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $shippingStatus;

	/**
	 * orderPdf
	 *
	 * @var string
	 */
	protected $orderPdf;


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
	 * Returns the paymentName
	 *
	 * @return string $paymentName
	 */
	public function getPaymentName() {
		return $this->paymentName;
	}

	/**
	 * Sets the paymentName
	 *
	 * @param string $paymentName
	 * @return void
	 */
	public function setPaymentName($paymentName) {
		$this->paymentName = $paymentName;
	}

	/**
	 * Returns the paymentId
	 *
	 * @return integer $paymentId
	 */
	public function getPaymentId() {
		return $this->paymentId;
	}

	/**
	 * Sets the paymentId
	 *
	 * @param integer $paymentId
	 * @return void
	 */
	public function setPaymentId($paymentId) {
		$this->paymentId = $paymentId;
	}

	/**
	 * Returns the paymentStatus
	 *
	 * @return integer $paymentStatus
	 */
	public function getPaymentStatus() {
		return $this->paymentStatus;
	}

	/**
	 * Sets the paymentStatus
	 *
	 * @param integer $paymentStatus
	 * @return void
	 */
	public function setPaymentStatus($paymentStatus) {
		$this->paymentStatus = $paymentStatus;
	}

	/**
	 * Returns the shippingName
	 *
	 * @return string $shippingName
	 */
	public function getShippingName() {
		return $this->shippingName;
	}

	/**
	 * Sets the shippingName
	 *
	 * @param string $shippingName
	 * @return void
	 */
	public function setShippingName($shippingName) {
		$this->shippingName = $shippingName;
	}

	/**
	 * Returns the shippingId
	 *
	 * @return integer $shippingId
	 */
	public function getShippingId() {
		return $this->shippingId;
	}

	/**
	 * Sets the shippingId
	 *
	 * @param integer $shippingId
	 * @return void
	 */
	public function setShippingId($shippingId) {
		$this->shippingId = $shippingId;
	}

	/**
	 * Returns the shippingStatus
	 *
	 * @return integer $shippingStatus
	 */
	public function getShippingStatus() {
		return $this->shippingStatus;
	}

	/**
	 * Sets the shippingStatus
	 *
	 * @param integer $shippingStatus
	 * @return void
	 */
	public function setShippingStatus($shippingStatus) {
		$this->shippingStatus = $shippingStatus;
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