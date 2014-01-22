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
	protected $count;

	/**
	 * Gross
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $gross;

	/**
	 * Gross
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $net;

	/**
	 * Tax
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $tax;

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
}

?>