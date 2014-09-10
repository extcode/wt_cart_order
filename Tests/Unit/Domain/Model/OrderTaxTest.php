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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_WtCartOrder_Domain_Model_OrderTax.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Order BE Handling
 *
 * @author Daniel Lorenz <wt_cart_order@extco.de>
 */
class Tx_WtCartOrder_Domain_Model_OrderTaxTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_WtCartOrder_Domain_Model_OrderTax
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_WtCartOrder_Domain_Model_OrderTax();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getCalcReturnsInitialValueForFloat() {
		$this->assertSame(
			0.0,
			$this->fixture->getCalc()
		);
	}

	/**
	 * @test
	 */
	public function setCalcForFloatSetsCalc() {
		$this->fixture->setCalc(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getCalc()
		);
	}

	/**
	 * @test
	 */
	public function getSumReturnsInitialValueForFloat() {
		$this->assertSame(
			0.0,
			$this->fixture->getSum()
		);
	}

	/**
	 * @test
	 */
	public function setSumForFloatSetsSum() {
		$this->fixture->setSum(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getSum()
		);
	}
}

?>