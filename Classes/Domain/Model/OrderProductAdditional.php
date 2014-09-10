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
class Tx_WtCartOrder_Domain_Model_OrderProductAdditional extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * AdditionalType
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $additionalType;

	/**
	 * AdditionalKey
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $additionalKey;

	/**
	 * AdditionalValue
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $additionalValue;

	/**
	 * Data
	 *
	 * @var string
	 */
	protected $additionalData;

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
	 * @param string $additionalKey
	 */
	public function setAdditionalKey($additionalKey) {
		$this->additionalKey = $additionalKey;
	}

	/**
	 * @return string
	 */
	public function getAdditionalKey() {
		return $this->additionalKey;
	}

	/**
	 * @param string $additionalType
	 */
	public function setAdditionalType($additionalType) {
		$this->additionalType = $additionalType;
	}

	/**
	 * @return string
	 */
	public function getAdditionalType() {
		return $this->additionalType;
	}

	/**
	 * @param string $additionalValue
	 */
	public function setAdditionalValue($additionalValue) {
		$this->additionalValue = $additionalValue;
	}

	/**
	 * @return string
	 */
	public function getAdditionalValue() {
		return $this->additionalValue;
	}
}

?>