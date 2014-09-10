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
class Tx_WtCartOrder_Domain_Model_OrderPayment extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Name
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * Status
	 *
	 * @var int
	 * @validate NotEmpty
	 */
	protected $status;

	/**
	 * Net
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $net = 0.0;

	/**
	 * Gross
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $gross = 0.0;

	/**
	 * Tax
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $tax = 0.0;

	/**
	 * Note
	 *
	 * @var string
	 */
	protected $note;

	/**
	 * @param float $gross
	 * @return void
	 */
	public function setGross($gross) {
		$this->gross = $gross;
	}

	/**
	 * @return float
	 */
	public function getGross() {
		return $this->gross;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param float $net
	 * @return void
	 */
	public function setNet($net) {
		$this->net = $net;
	}

	/**
	 * @return float
	 * @return void
	 */
	public function getNet() {
		return $this->net;
	}

	/**
	 * @param float $tax
	 * @return void
	 */
	public function setTax($tax) {
		$this->tax = $tax;
	}

	/**
	 * @return float
	 */
	public function getTax() {
		return $this->tax;
	}

	/**
	 * @param int $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @return int
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param string $note
	 */
	public function setNote($note) {
		$this->note = $note;
	}

	/**
	 * @return string
	 */
	public function getNote() {
		return $this->note;
	}

}

?>