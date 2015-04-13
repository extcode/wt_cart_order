<?php

namespace Extcode\WtCartOrder\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Daniel Lorenz <wt-cart-order@extco.de>, extco.de UG (haftungsbeschränkt)
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
class OrderProductAdditionalRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Count all by Category
	 *
	 * @param array $piVars Plugin Variables
	 * @param $additionalType
	 * @return Query Object
	 */
	public function findAllByAdditionalType($piVars = array(), $additionalType) {
		// settings
		$query = $this->createQuery();

		$and = array(
			$query->equals('deleted', 0),
			$query->equals('additionalType', $additionalType)
		);

		// filter
		if (isset($piVars['filter'])) {
			foreach ((array) $piVars['filter'] as $field => $value) {

				if ($field == 'start' && !empty($value)) {
					$and[] = $query->greaterThan('crdate', strtotime($value));
				} elseif ($field == 'stop' && !empty($value)) {
					$and[] = $query->lessThan('crdate', strtotime($value));
				}
			}
		}

		// create constraint
		$constraint = $query->logicalAnd($and);
		$query->matching($constraint);

		$orderProductAdditionals = $query->execute();
		return $orderProductAdditionals;
	}
}
?>