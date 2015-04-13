<?php

namespace Extcode\WtCartOrder\Domain\Model;

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
class OrderProduct extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * orderItem
	 *
	 * @var \Extcode\WtCartOrder\Domain\Model\OrderItem
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
	 * OrderTax
	 *
	 * @var \Extcode\WtCartOrder\Domain\Model\OrderTax
	 * @validate NotEmpty
	 */
	protected $orderTax;

	/**
	 * Additional Data
	 *
	 * @var string
	 */
	protected $additionalData;

	/**
	 * orderProductAdditional
	 *
	 * @var  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\WtCartOrder\Domain\Model\OrderProductAdditional>
	 */
	protected $orderProductAdditional;

	/**
	 * __construct
	 *
	 * @return \Extcode\WtCartOrder\Domain\Model\OrderProduct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}


	/**
	 * Initializes all  \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->orderProductAdditional = new  \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderTax $orderTax
	 * @return void
	 */
	public function setOrderTax($orderTax) {
		$this->orderTax = $orderTax;
	}

	/**
	 * @return \Extcode\WtCartOrder\Domain\Model\OrderTax
	 */
	public function getOrderTax() {
		return $this->orderTax;
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
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderProductAdditional $orderProductAdditional
	 * @return void
	 */
	public function addOrderProductAdditional($orderProductAdditional) {
		$this->orderProductAdditional->attach($orderProductAdditional);
	}

	/**
	 * Removes a OrderProductAdditional
	 *
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderProductAdditional $orderProductAdditionalToRemove The OrderProductAdditional to be removed
	 * @return void
	 */
	public function removeOrderProductAdditional($orderProductAdditionalToRemove) {
		$this->orderProductAdditional->detach($orderProductAdditionalToRemove);
	}

	/**
	 * Returns the orderProductAdditional
	 *
	 * @return  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\WtCartOrder\Domain\Model\OrderProductAdditional> $orderProductAdditional
	 */
	public function getOrderProductAdditional() {
		return $this->orderProductAdditional;
	}

	/**
	 * Sets the orderProductAdditional
	 *
	 * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\WtCartOrder\Domain\Model\OrderProductAdditional> $orderProductAdditional
	 * @return void
	 */
	public function setOrderProductAdditional($orderProductAdditional) {
		$this->orderProductAdditional = $orderProductAdditional;
	}

	/**
	 * @return \Extcode\WtCartOrder\Domain\Model\OrderItem
	 */
	public function getOrderItem() {
		return $this->orderItem;
	}
}

?>