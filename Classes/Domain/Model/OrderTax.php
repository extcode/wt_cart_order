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
class OrderTax extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Tax
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $tax;

	/**
	 * TaxClass
	 *
	 * @var \Extcode\WtCartOrder\Domain\Model\OrderTaxClass
	 * @validate NotEmpty
	 */
	protected $orderTaxClass;

	/**
	 * @return float
	 */
	public function getTax() {
		return $this->tax;
	}

	/**
	 * @param float $tax
	 */
	public function setTax( $tax ) {
		$this->tax = $tax;
	}

	/**
	 * @return \Extcode\WtCartOrder\Domain\Model\OrderTaxClass
	 */
	public function getOrderTaxClass() {
		return $this->orderTaxClass;
	}

	/**
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderTaxClass $orderTaxClass
	 */
	public function setOrderTaxClass( $orderTaxClass ) {
		$this->orderTaxClass = $orderTaxClass;
	}

}

?>