<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Sebastian Wagner <sebastian.wagner@tritum.de>, tritum.de
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

define('TYPO3_DLOG', $GLOBALS['TYPO3_CONF_VARS']['SYS']['enable_DLOG']);

require_once(t3lib_extMgm::extPath('wt_cart') . 'lib/class.tx_wtcart_div.php');

/**
 *
 *
 * @package wt_cart_order
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_WtCartOrder_Hooks_OrderHook extends Tx_Powermail_Controller_FormsController {

	/**
	 * @param $params
	 * @param $obj
	 */
	public function afterSetOrderNumber( &$params, &$obj ) {

		$this->formsRepository = t3lib_div::makeInstance('Tx_Powermail_Domain_Repository_FormsRepository');

		$this->wtcart_conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_pi1.'];

		/**
		 * @var $cart Tx_WtCart_Domain_Model_Cart
		 */
		$cart = $params['cart'];

		if ( !cart ) {
			return;
		}

		/**
		 * @var $orderItem Tx_WtCartOrder_Domain_Model_OrderItem
		 */
		$orderItem = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderItem');
		$orderItem->setOrderNumber( $cart->getOrderNumber() );
		$orderItem->setGross( $cart->getGross() );
		$orderItem->setNet( $cart->getNet() );
		$orderItem->setPaymentName( $cart->getPayment()->getName() );
		$orderItem->setPaymentId( $cart->getPayment()->getId() );
		$orderItem->setPaymentStatus( $cart->getPayment()->getStatus() );
		$orderItem->setShippingName( $cart->getShipping()->getName() );
		$orderItem->setShippingId( $cart->getShipping()->getId() );
		$orderItem->setShippingStatus( $cart->getShipping()->getStatus() );

		if ( ! $orderItem->_isDirty() ) {
			$orderItemRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderItemRepository');
			$orderItemRepository->add($orderItem);

			if ($cart->getTaxes()) {
				$this->addTaxesToOrder( $cart, $orderItem );
			}

			if ($cart->getProducts()) {
				$this->addProductsToOrder( $cart, $orderItem );
			}
		}

		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$persistenceManager->persistAll();

		$cart->setOrderId( $orderItem->getUid() );

	}

	/**
	 * @param Tx_WtCart_Domain_Model_Cart $cart
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 */
	protected function addTaxesToOrder( $cart, &$orderItem ) {
		$orderTaxRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderTaxRepository');

		foreach ( $cart->getTaxes() as $cartTaxKey => $cartTaxValue ) {
			/**
			 * @var $orderTax Tx_WtCartOrder_Domain_Model_OrderTax
			 */
			$orderTax = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderTax');

			$orderTax->setName( $this->wtcart_conf['taxclass.'][$cartTaxKey . '.']['name'] );
			$orderTax->setCalc( $this->wtcart_conf['taxclass.'][$cartTaxKey . '.']['calc'] );
			$orderTax->setValue( $this->wtcart_conf['taxclass.'][$cartTaxKey . '.']['value'] );
			$orderTax->setSum( $cartTaxValue );

			$orderTaxRepository->add( $orderTax );

			$orderItem->addOrderTax( $orderTax );
		}
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Cart $cart
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 */
	protected function addProductsToOrder( $cart, &$orderItem ) {

		/**
		 * @var $cartProduct Tx_WtCart_Domain_Model_Product
		 */
		foreach ( $cart->getProducts() as $cartProduct ) {

			if ( $cartProduct->getVariants() ) {
				$this->addVariantsOfProductToOrder( $cartProduct, $orderItem );
			} else {
				$this->addProductToOrder( $cartProduct, $orderItem );
			}
		}
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Product $cartProduct
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 */
	protected function addProductToOrder( $cartProduct, &$orderItem ) {
		$orderProductRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderProductRepository');

		/**
		 * @var $orderProduct Tx_WtCartOrder_Domain_Model_OrderProduct
		 */
		$orderProduct = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderProduct');

		$orderProduct->setTitle( $cartProduct->getTitle() );
		$orderProduct->setSku( $cartProduct->getSku() );
		$orderProduct->setCount( $cartProduct->getQty() );
		$orderProduct->setGross( $cartProduct->getGross() );
		$orderProduct->setNet( $cartProduct->getNet() );
		$cartProductTax = $cartProduct->getTax();
		$orderProduct->setTax( $cartProductTax['tax'] );

		$orderProductRepository->add($orderProduct);

		$orderItem->addOrderProduct($orderProduct);
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Product $cartProduct
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 */
	protected function addVariantsOfProductToOrder($cartProduct, &$orderItem) {
		foreach ( $cartProduct->getVariants() as $cartVariant ) {
			if ( $cartVariant->getVariants() ) {
				$this->addVariantsOfVariantToOrder($cartVariant, 1, $orderItem);
			} else {
				$this->addVariantToOrder($cartVariant, 1, $orderItem);
			}
		}
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Variant $cartVariant
	 * @param int $level
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 */
	protected function addVariantsOfVariantToOrder( $cartVariant, $level, &$orderItem ) {
		$level += 1;

		foreach ( $cartVariant->getVariants() as $cartVariantInner ) {
			if ( $cartVariantInner->getVariants() ) {
				$this->addVariantsOfVariantToOrder( $cartVariantInner, $level, $orderItem );
			} else {
				$this->addVariantToOrder( $cartVariantInner, $level, $orderItem );
			}
		}
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Variant $cartVariant
	 * @param int $level
	 * @param Tx_WtCartOrder_Domain_Model_OrderItem $orderItem
	 */
	protected function addVariantToOrder( $cartVariant, $level, &$orderItem ) {
		$orderProductRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderProductRepository');

		/**
		 * @var $orderProduct Tx_WtCartOrder_Domain_Model_OrderProduct
		 */
		$orderProduct = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderProduct');

		$skuWithVariants = array();
		$titleWithVariants = array();

		$cartVariantInner = $cartVariant;
		for ( $count = $level; $count > 0; $count-- ) {
			$skuWithVariants['variantsku' . $count] = $cartVariantInner->getSku();
			$titleWithVariants['varianttitle' . $count] = $cartVariantInner->getTitle();

			if ( $count > 1 ) {
				$cartVariantInner = $cartVariantInner->getParentVariant();
			} else {
				$cartProduct = $cartVariantInner->getProduct();
			}
		}
		unset($cartVariantInner);

		$skuWithVariants['sku'] = $cartProduct->getSku();
		$skuWithVariants['title'] = $cartProduct->getTitle();

		$orderProduct->setTitle( $this->getTitleFromTypoScript( $titleWithVariants ) );
		$orderProduct->setSku( $this->getSkuFromTypoScript( $skuWithVariants ) );
		$orderProduct->setCount( $cartVariant->getQty() );
		$orderProduct->setGross( $cartVariant->getGross() );
		$orderProduct->setNet( $cartVariant->getNet() );
		$cartVariantTax = $cartVariant->getTax();
		$orderProduct->setTax( $cartVariantTax['tax'] );

		$orderProductRepository->add($orderProduct);

		$orderItem->addOrderProduct($orderProduct);
	}

	/**
	 * @param array $skuWithVariants
	 * @return string
	 */
	protected function getSkuFromTypoScript( $skuWithVariants ) {
		$conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_pi1.']['settings.']['fields.'];

		$cObj = $this->getCObj();
		$cObj->start( $skuWithVariants, $conf['sku_with_variants'] );
		$sku = $cObj->cObjGetSingle( $conf['sku_with_variants'], $conf['sku_with_variants.'] );

		return $sku;
	}

	/**
	 * @param array $titleWithVariants
	 * @return string
	 */
	protected function getTitleFromTypoScript( $titleWithVariants ) {
		$conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_pi1.']['settings.']['fields.'];

		$cObj = $this->getCObj();
		$cObj->start( $titleWithVariants, $conf['title_with_variants'] );
		$title = $cObj->cObjGetSingle( $conf['title_with_variants'], $conf['title_with_variants.'] );

		return $title;
	}

	protected function getCObj() {
		if ( !$this->cObj ) {
			$this->cObj = t3lib_div::makeInstance( 'tslib_cObj' );
		}

		return $this->cObj;
	}

}

?>