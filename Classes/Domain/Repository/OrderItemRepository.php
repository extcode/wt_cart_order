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
class OrderItemRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	protected $defaultOrderings = array(
		'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
	);

	/**
	 * Find a order by a given orderNumber
	 *
	 * @param string $orderNumber
	 * @return object
	 */
	public function findOneByOrderNumber( $orderNumber ) {
		$query = $this->createQuery();

		$query->getQuerySettings()->setRespectStoragePage( FALSE );
		$query->getQuerySettings()->setRespectEnableFields( FALSE );
		$query->getQuerySettings()->setRespectSysLanguage( FALSE );

		$query->matching( $query->equals( 'order_number', $orderNumber ) );
		$orderItem = $query->execute()->getFirst();

		return $orderItem;
	}

	/**
	 * Find all orders
	 *
	 * @param 	array 	Plugin Variables
	 * @return	Query Object
	 */
	public function findAll($piVars = array()) {
		// settings
		$query = $this->createQuery();

		$and = array(
			$query->equals('deleted', 0)
		);

		// filter
		if ( isset($piVars['filter']) ) {
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

		$orderItems = $query->execute();
		return $orderItems;
	}

}
?>