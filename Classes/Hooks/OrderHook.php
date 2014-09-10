<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Sebastian Wagner <sebastian.wagner@tritum.de>, tritum.de
 *  (c) Daniel Lorenz <wt_cart_order@extco.de>, extco.de UG (haftungsbeschränkt)
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
	 * formsRepository
	 *
	 * @var Tx_Powermail_Domain_Repository_FormsRepository
	 * @inject
	 */
	protected $formsRepository;

	/**
	 * frontendUserRepository
	 *
	 * @var Tx_Extbase_Domain_Repository_FrontendUserRepository
	 * @inject
	 */
	protected $frontendUserRepository;

	/**
	 * orderItemRepository
	 *
	 * @var Tx_WtCartOrder_Domain_Repository_OrderItemRepository
	 */
	protected $orderItemRepository;

	/**
	 * orderItem
	 *
	 * @var Tx_WtCartOrder_Domain_Model_OrderItem
	 */
	protected $orderItem;

	/**
	 * storagePid
	 *
	 * @var int
	 */
	protected $storagePid;

	/**
	 * @var Tx_Extbase_SignalSlot_Dispatcher
	 */
	protected $signalSlotDispatcher;

	/**
	 * cart
	 *
	 * @var Tx_WtCart_Domain_Model_Cart
	 */
	protected $cart;

	/**
	 *
	 */
	protected function getOrderItemRepository() {
		if ( ! $this->orderItemRepository ) {
			$this->orderItemRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderItemRepository');
		}
	}

	/**
	 *
	 */
	protected function getOrderItem() {
		if ( ! $this->orderItem ) {
			$this->orderItem = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderItem');
		}
	}

	public function createOrderItemFromCart( &$params, &$obj ) {
		$this->formsRepository = t3lib_div::makeInstance('Tx_Powermail_Domain_Repository_FormsRepository');
		$this->frontendUserRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository');

		$this->wtcart_conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_pi1.'];

		$this->conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_order.'];

		$this->storagePid = intval( $GLOBALS['TSFE']->tmpl->setup['module.']['tx_wtcartorder.']['persistence.']['storagePid'] );

		$this->cart = $params['cart'];

		if ( !$this->cart ) {
			return;
		}

		$this->getOrderItemRepository();
		$this->getOrderItem();

		$this->orderItem->setPid( $this->storagePid );

		$user = $GLOBALS['TSFE']->fe_user->user;
		$fe_user = $this->frontendUserRepository->findByUid( $user['uid'] );
		if ( $fe_user ) {
			$this->orderItem->setFeUser( $fe_user );
		}

		$this->orderItem->setGross( $this->cart->getGross() );
		$this->orderItem->setNet( $this->cart->getNet() );

		$this->orderItem->setFirstName( $GLOBALS['TSFE']->cObj->cObjGetSingle( $this->conf['firstName'], $this->conf['firstName.'] ) );
		$this->orderItem->setLastName( $GLOBALS['TSFE']->cObj->cObjGetSingle( $this->conf['lastName'], $this->conf['lastName.'] ) );
		$this->orderItem->setEmail( $GLOBALS['TSFE']->cObj->cObjGetSingle( $this->conf['email'], $this->conf['email.'] ) );
		$billingAddress = $GLOBALS['TSFE']->cObj->cObjGetSingle( $this->conf['billingAddress'], $this->conf['billingAddress.'] );
		if ( $billingAddress ) {
			$this->orderItem->setBillingAddress( $billingAddress );
		}
		$shippingAddress = $GLOBALS['TSFE']->cObj->cObjGetSingle( $this->conf['shippingAddress'], $this->conf['shippingAddress.'] );
		if ( $shippingAddress ) {
			$this->orderItem->setShippingAddress( $shippingAddress );
		}
		$additionalData = $GLOBALS['TSFE']->cObj->cObjGetSingle( $this->conf['additionalData'], $this->conf['additionalData.'] );
		if ( $additionalData ) {
			$this->orderItem->setAdditionalData( $additionalData );
		}

		if ( ! $this->orderItem->_isDirty() ) {
			$this->orderItemRepository->add($this->orderItem);

			if ( $this->cart->getTaxes() ) {
				$this->addTaxesToOrder();
			}

			if ( $this->cart->getProducts() ) {
				$this->addProductsToOrder();
			}

			if ( $this->cart->getPayment() ) {
				$this->addPaymentToOrder();
			}
			if ( $this->cart->getShipping() ) {
				$this->addShippingToOrder();
			}
		}

		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$persistenceManager->persistAll();

		$this->cart->setOrderId( $this->orderItem->getUid() );
	}

	/**
	 * @param $params
	 * @param $obj
	 * @return int
	 */
	public function afterSetOrderNumber( &$params, &$obj ) {
		$this->cart = $params['cart'];

		$orderId = $this->cart->getOrderId();
		$orderNumber = $this->cart->getOrderNumber();

		if ( empty( $orderId ) || empty( $orderNumber ) ) {
			return -1;
		}

		$this->getOrderItemRepository();
		/**
		 * @var $orderItem Tx_WtCartOrder_Domain_Model_OrderItem
		 */
		$orderItem = $this->orderItemRepository->findByUid( $orderId );

		$newOrderNumber = $orderItem->setOrderNumber( $orderNumber );

		if ( $newOrderNumber != $orderNumber) {
			$params['errors']['afterSetOrderNumber'] = 'Order Number can not be replaced.';
			if ( TYPO3_DLOG ) {
				t3lib_div::devLog( $params['errors']['afterSetOrderNumber'], 'wt_cart_order', 0, array( 'orderNumber' => $orderNumber, 'newOrderNumber' => $newOrderNumber ) );
			}
			return -2;
		}

		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$persistenceManager->persistAll();

		$files = array();
		$errors = array();

		$data = array(
			'orderItem' => $orderItem,
			'type' => 'order',
			'files' => &$files,
			'errors' => &$errors
		);

		$this->signalSlotDispatcher = t3lib_div::makeInstance('Tx_Extbase_Object_Manager')->get('Tx_Extbase_SignalSlot_Dispatcher');
		$this->signalSlotDispatcher->dispatch( __CLASS__, 'slotAfterSaveOrderNumberToOrderItem', array( $data ) );

		t3lib_div::devLog( 'afterSetOrderNumber', 'wt_cart_order', 0, array( 'data' => $data ) );

		if ( $data['files']['order'] ) {
			$orderItem->setOrderPdf( $data['files']['order'] );
			$persistenceManager->persistAll();
		}
	}

	/**
	 * @param $params
	 * @param $obj
	 * @return int
	 */
	public function afterSetInvoiceNumber( &$params, &$obj ) {
		$this->cart = $params['cart'];

		$orderId = $this->cart->getOrderId();
		$invoiceNumber = $this->cart->getInvoiceNumber();

		if ( empty( $orderId ) || empty( $invoiceNumber ) ) {
			return -1;
		}

		$this->getOrderItemRepository();
		/**
		 * @var $orderItem Tx_WtCartOrder_Domain_Model_OrderItem
		 */
		$orderItem = $this->orderItemRepository->findByUid( $orderId );

		$newInvoiceNumber = $orderItem->setInvoiceNumber( $invoiceNumber );

		if ( $newInvoiceNumber != $invoiceNumber) {
			$params['errors']['afterSetInvoiceNumber'] = 'Invoice Number can not be replaced.';
			if ( TYPO3_DLOG ) {
				t3lib_div::devLog( $params['errors']['afterSetInvoiceNumber'], 'wt_cart_order', 0, array( 'invoiceNumber' => $invoiceNumber, 'newInvoiceNumber' => $newInvoiceNumber ) );
			}
			return -2;
		}

		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$persistenceManager->persistAll();

		$files = array();
		$errors = array();

		$data = array(
			'orderItem' => $orderItem,
			'type' => 'invoice',
			'files' => &$files,
			'errors' => &$errors
		);

		$this->signalSlotDispatcher = t3lib_div::makeInstance('Tx_Extbase_Object_Manager')->get('Tx_Extbase_SignalSlot_Dispatcher');
		$this->signalSlotDispatcher->dispatch( __CLASS__, 'slotAfterSaveInvoiceNumberToOrderItem', array( $data ) );

		if ( $data['files']['invoice'] ) {
			$orderItem->setInvoicePdf( $data['files']['invoice'] );
			$persistenceManager->persistAll();
		}
	}

	/**
	 * @param $params
	 * @param $obj
	 */
	public function beforeAddAttachmentToMail( &$params, &$obj ) {
		$this->cart = $params['cart'];

		$orderId = $this->cart->getOrderId();

		$this->getOrderItemRepository();
		/**
		 * @var $orderItem Tx_WtCartOrder_Domain_Model_OrderItem
		 */
		$orderItem = $this->orderItemRepository->findByUid( $orderId );

		if ($orderItem) {
			if ( $params['files']['order'] ) {
				$orderItem->setOrderPdf( $params['files']['order'] );
			}
			if ( $params['files']['invoice'] ) {
				$orderItem->setInvoicePdf( $params['files']['invoice'] );
			}
		}
	}

	/**
	 *
	 */
	protected function addTaxesToOrder() {
		$orderTaxRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderTaxRepository');

		foreach ( $this->cart->getTaxes() as $cartTaxKey => $cartTaxValue ) {
			/**
			 * @var $orderTax Tx_WtCartOrder_Domain_Model_OrderTax
			 */
			$orderTax = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderTax');
			$orderTax->setPid( $this->storagePid );

			$orderTax->setName( $this->wtcart_conf['taxclass.'][$cartTaxKey . '.']['name'] );
			$orderTax->setCalc( $this->wtcart_conf['taxclass.'][$cartTaxKey . '.']['calc'] );
			$orderTax->setValue( $this->wtcart_conf['taxclass.'][$cartTaxKey . '.']['value'] );
			$orderTax->setSum( $cartTaxValue );

			$orderTaxRepository->add( $orderTax );

			$this->orderItem->addOrderTax( $orderTax );
		}
	}

	/**
	 *
	 */
	protected function addShippingToOrder() {
		$orderShippingRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderShippingRepository');

		/**
		 * @var $orderShipping Tx_WtCartOrder_Domain_Model_OrderShipping
		 */
		$orderShipping = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderShipping');
		$orderShipping->setPid( $this->storagePid );

		$orderShipping->setName( $this->cart->getShipping()->getName() );
		$orderShipping->setStatus( $this->cart->getShipping()->getStatus() );
		$orderShipping->setGross( $this->cart->getShipping()->getGross( $this->cart ) );
		$orderShipping->setNet( $this->cart->getShipping()->getNet( $this->cart ) );
		$taxes = $this->cart->getShipping()->getTax( $this->cart );
		$orderShipping->setTax( $taxes['tax'] );

		$orderShippingRepository->add( $orderShipping );

		$this->orderItem->setOrderShipping( $orderShipping );
	}

	/**
	 *
	 */
	protected function addPaymentToOrder() {
		$orderPaymentRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderPaymentRepository');

		/**
		 * @var $orderPayment Tx_WtCartOrder_Domain_Model_OrderPayment
		 */
		$orderPayment = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderPayment');
		$orderPayment->setPid( $this->storagePid );

		$orderPayment->setName( $this->cart->getPayment()->getName() );
		$orderPayment->setStatus( $this->cart->getPayment()->getStatus() );
		$orderPayment->setGross( $this->cart->getPayment()->getGross( $this->cart ) );
		$orderPayment->setNet( $this->cart->getPayment()->getNet( $this->cart ) );
		$taxes = $this->cart->getPayment()->getTax( $this->cart );
		$orderPayment->setTax( $taxes['tax'] );

		$orderPaymentRepository->add( $orderPayment );

		$this->orderItem->setOrderPayment( $orderPayment );
	}

	/**
	 *
	 */
	protected function addProductsToOrder() {

		/**
		 * @var $cartProduct Tx_WtCart_Domain_Model_Product
		 */
		foreach ( $this->cart->getProducts() as $cartProduct ) {

			if ( $cartProduct->getVariants() ) {
				$this->addVariantsOfProductToOrder( $cartProduct );
			} else {
				$this->addProductToOrder( $cartProduct );
			}
		}
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Product $cartProduct
	 */
	protected function addProductToOrder( $cartProduct ) {
		$orderProductRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderProductRepository');

		/**
		 * @var $orderProduct Tx_WtCartOrder_Domain_Model_OrderProduct
		 */
		$orderProduct = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderProduct');
		$orderProduct->setPid( $this->storagePid );

		$orderProduct->setTitle( $cartProduct->getTitle() );
		$orderProduct->setSku( $cartProduct->getSku() );
		$orderProduct->setCount( $cartProduct->getQty() );
		$orderProduct->setGross( $cartProduct->getGross() );
		$orderProduct->setNet( $cartProduct->getNet() );
		$cartProductTax = $cartProduct->getTax();
		$orderProduct->setTax( $cartProductTax['tax'] );

		$additionalArray = $cartProduct->getAdditionalArray();

		$data = array(
			'cartProduct' => $cartProduct,
			'orderProduct' => &$orderProduct,
			'additionalArray' => &$additionalArray,
			'storagePid' => $this->storagePid,
		);

		$this->signalSlotDispatcher = t3lib_div::makeInstance('Tx_Extbase_Object_Manager')->get('Tx_Extbase_SignalSlot_Dispatcher');
		$this->signalSlotDispatcher->dispatch( __CLASS__, 'slotBeforeSetAdditionalArrayToOrderProduct', array( $data ) );

		$orderProduct->setAdditionalData( json_encode( $data['additionalArray'] ) );

		$orderProductRepository->add($orderProduct);

		$this->orderItem->addOrderProduct($orderProduct);
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Product $cartProduct
	 */
	protected function addVariantsOfProductToOrder( $cartProduct ) {
		foreach ( $cartProduct->getVariants() as $cartVariant ) {
			if ( $cartVariant->getVariants() ) {
				$this->addVariantsOfVariantToOrder( $cartVariant, 1 );
			} else {
				$this->addVariantToOrder( $cartVariant, 1 );
			}
		}
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Variant $cartVariant
	 * @param int $level
	 */
	protected function addVariantsOfVariantToOrder( $cartVariant, $level ) {
		$level += 1;

		foreach ( $cartVariant->getVariants() as $cartVariantInner ) {
			if ( $cartVariantInner->getVariants() ) {
				$this->addVariantsOfVariantToOrder( $cartVariantInner, $level );
			} else {
				$this->addVariantToOrder( $cartVariantInner, $level );
			}
		}
	}

	/**
	 * @param Tx_WtCart_Domain_Model_Variant $cartVariant
	 * @param int $level
	 */
	protected function addVariantToOrder( $cartVariant, $level ) {
		$orderProductRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderProductRepository');
		$orderProductAdditionalRepository = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Repository_OrderProductAdditionalRepository');

		/**
		 * @var $orderProduct Tx_WtCartOrder_Domain_Model_OrderProduct
		 */
		$orderProduct = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderProduct');
		$orderProduct->setPid( $this->storagePid );

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
		$titleWithVariants['title'] = $cartProduct->getTitle();

		$orderProduct->setTitle( $this->getTitleFromTypoScript( $titleWithVariants ) );
		$orderProduct->setSku( $this->getSkuFromTypoScript( $skuWithVariants ) );
		$orderProduct->setCount( $cartVariant->getQty() );
		$orderProduct->setPrice( $cartVariant->getPrice() );
		$orderProduct->setDiscount( $cartVariant->getDiscount() );
		$orderProduct->setGross( $cartVariant->getGross() );
		$orderProduct->setNet( $cartVariant->getNet() );
		$cartVariantTax = $cartVariant->getTax();
		$orderProduct->setTax( $cartVariantTax['tax'] );

		if ( ! $orderProduct->_isDirty() ) {
			$orderProductRepository->add($orderProduct);
		}

		$cartVariantInner = $cartVariant;
		for ( $count = $level; $count > 0; $count-- ) {
			/**
			 * @var $orderProductAdditional Tx_WtCartOrder_Domain_Model_OrderProductAdditional
			 */
			$orderProductAdditional = t3lib_div::makeInstance('Tx_WtCartOrder_Domain_Model_OrderProductAdditional');
			$orderProductAdditional->setPid( $this->storagePid );
			$orderProductAdditional->setAdditionalType( 'variant_' . $count );
			$orderProductAdditional->setAdditionalKey( $cartVariantInner->getSku() );
			$orderProductAdditional->setAdditionalValue( $cartVariantInner->getTitle() );

			$orderProductAdditionalRepository->add($orderProductAdditional);

			$orderProduct->addOrderProductAdditional($orderProductAdditional);

			if ( $count > 1 ) {
				$cartVariantInner = $cartVariantInner->getParentVariant();
			} else {
				$cartProduct = $cartVariantInner->getProduct();
			}
		}
		unset($cartVariantInner);

		$additionalArray = $cartProduct->getAdditionalArray();

		$data = array(
			'cartProduct' => $cartProduct,
			'orderProduct' => &$orderProduct,
			'additionalArray' => &$additionalArray,
			'storagePid' => $this->storagePid,
		);

		$this->signalSlotDispatcher = t3lib_div::makeInstance('Tx_Extbase_Object_Manager')->get('Tx_Extbase_SignalSlot_Dispatcher');
		$this->signalSlotDispatcher->dispatch( __CLASS__, 'slotBeforeSetAdditionalArrayToOrderProduct', array( $data ) );

		$orderProduct->setAdditionalData( json_encode( $data['additionalArray'] ) );

		$orderProductRepository->add($orderProduct);

		$this->orderItem->addOrderProduct($orderProduct);
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