<?php

namespace Extcode\WtCartOrder\ViewHelpers;

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
 * Format array of values to CSV format
 *
 * @package wt_cart_order
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CsvValuesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * Format OrderItem to CSV format
	 *
	 * @param \Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem array of values to output in CSV format
	 * @param string $delim
	 * @param string $quote
	 * @return string
	 */
	public function render(\Extcode\WtCartOrder\Domain\Model\OrderItem $orderItem, $delim = ',', $quote = '"') {

		$orderItemArr = array();

		$orderItemArr[] = $orderItem->getFirstName();
		$orderItemArr[] = $orderItem->getLastName();
		$orderItemArr[] = $orderItem->getOrderNumber();
		$orderItemArr[] = $orderItem->getInvoiceNumber();

		return \TYPO3\CMS\Core\Utility\GeneralUtility::csvValues($orderItemArr, $delim, $quote);
	}
}