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
class Tx_WtCartOrder_Domain_Model_OrderProduct extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * orderItem
	 *
	 * @var Tx_WtCartOrder_Domain_Model_OrderItem
	 */
	protected $orderItem;

	/**
	 * Sku
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $sku;

	/**
	 * Title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Count
	 *
	 * @var int
	 * @validate NotEmpty
	 */
	protected $count = 0;

	/**
	 * Price
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $price = 0.0;

	/**
	 * Discount
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $discount = 0.0;

	/**
	 * Gross
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $gross = 0.0;

	/**
	 * Gross
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $net = 0.0;

	/**
	 * Tax
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $tax = 0.0;

	/**
	 * Additional Data
	 *
	 * @var string
	 */
	protected $additionalData;

	/**
	 * orderProductAdditional
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderProductAdditional>
	 */
	protected $orderProductAdditional;

	/**
	 * __construct
	 *
	 * @return \Tx_WtCartOrder_Domain_Model_OrderProduct
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
		$this->orderProductAdditional = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * @return string
	 */
	public function getAdditionalData() {
		return $this->additionalData;
	}

	/**
	 * @param string $additionalData
	 */
	public function setAdditionalData($additionalData) {
		$this->additionalData = $additionalData;
	}

	/**
	 * @param int $count
	 */
	public function setCount($count) {
		$this->count = $count;
	}

	/**
	 * @return int
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * @param float $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
	}

	/**
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param float $discount
	 */
	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	/**
	 * @return float
	 */
	public function getDiscount()
	{
		return $this->discount;
	}

	/**
	 * @param float $gross
	 */
	public function setGross($gross)
	{
		$this->gross = $gross;
	}

	/**
	 * @return float
	 */
	public function getGross()
	{
		return $this->gross;
	}

	/**
	 * @param float $net
	 */
	public function setNet($net)
	{
		$this->net = $net;
	}

	/**
	 * @return float
	 */
	public function getNet()
	{
		return $this->net;
	}

	/**
	 * @param string $sku
	 */
	public function setSku($sku) {
		$this->sku = $sku;
	}

	/**
	 * @return string
	 */
	public function getSku() {
		return $this->sku;
	}

	/**
	 * @param float $tax
	 */
	public function setTax($tax)
	{
		$this->tax = $tax;
	}

	/**
	 * @return float
	 */
	public function getTax()
	{
		return $this->tax;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Adds a OrderProductAdditional
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderProductAdditional $orderProductAdditional
	 * @return void
	 */
	public function addOrderProductAdditional(Tx_WtCartOrder_Domain_Model_OrderProductAdditional $orderProductAdditional) {
		$this->orderProductAdditional->attach($orderProductAdditional);
	}

	/**
	 * Removes a OrderProductAdditional
	 *
	 * @param Tx_WtCartOrder_Domain_Model_OrderProductAdditional $orderProductAdditionalToRemove The OrderProductAdditional to be removed
	 * @return void
	 */
	public function removeOrderProductAdditional(Tx_WtCartOrder_Domain_Model_OrderProductAdditional $orderProductAdditionalToRemove) {
		$this->orderProductAdditional->detach($orderProductAdditionalToRemove);
	}

	/**
	 * Returns the orderProductAdditional
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderProductAdditional> $orderProductAdditional
	 */
	public function getOrderProductAdditional() {
		return $this->orderProductAdditional;
	}

	/**
	 * Sets the orderProductAdditional
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_WtCartOrder_Domain_Model_OrderProductAdditional> $orderProductAdditional
	 * @return void
	 */
	public function setOrderProductAdditional(Tx_Extbase_Persistence_ObjectStorage $orderProductAdditional) {
		$this->orderProductAdditional = $orderProductAdditional;
	}

	/**
	 * @return Tx_WtCartOrder_Domain_Model_OrderItem
	 */
	public function getOrderItem() {
		return $this->orderItem;
	}
}

?>