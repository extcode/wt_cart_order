<?php

namespace Extcode\WtCartOrder\Hooks;

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

/**
 *
 *
 * @package wt_cart_order
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class OrderHook extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $frontendUserRepository;

	/**
	 * orderItemRepository
	 *
	 * @var \Extcode\WtCartOrder\Domain\Repository\OrderItemRepository
	 * @inject
	 */
	protected $orderItemRepository;

	/**
	 * orderItem
	 *
	 * @var \Extcode\WtCartOrder\Domain\Model\OrderItem
	 */
	protected $orderItem;

	/**
	 * storagePid
	 *
	 * @var int
	 */
	protected $storagePid;

	/**
	 * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
	 */
	protected $signalSlotDispatcher;

	/**
	 * cart
	 *
	 * @var Tx_WtCart_Domain_Model_Cart
	 */
	protected $cart;

	/**
	 * @var array \Extcode\WtCartOrder\Domain\Model\OrderTaxClass
	 */
	private $taxClass;

	/**
	 *
	 */
	protected function getObjectManager() {
		if ( ! $this->objectManager ) {
			$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		}
	}

	/**
	 *
	 */
	protected function getOrderItemRepository() {
		if ( ! $this->orderItemRepository ) {
			$this->orderItemRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderItemRepository');
		}
	}

	/**
	 *
	 */
	protected function getOrderItem() {
		if ( ! $this->orderItem ) {
			$this->orderItem = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderItem');
		}
	}

	public function createOrderItemFromCart( &$params, &$obj ) {
		$this->getObjectManager();

		$this->frontendUserRepository = $this->objectManager->get('\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository');

		$this->wtcart_conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_pi1.'];

		$this->conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_wtcart_order.'];

		$this->storagePid = intval( $GLOBALS['TSFE']->tmpl->setup['module.']['tx_wtcartorder.']['persistence.']['storagePid'] );

		$this->cart = $params['cart'];

		if ( !$this->cart ) {
			return;
		}

		$this->addTaxClasses();

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
		$this->orderItem->setTotalGross( $this->cart->getTotalGross() );
		$this->orderItem->setTotalNet( $this->cart->getTotalNet() );

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

			$this->addTaxesToOrder( 'TotalTax' );
			$this->addTaxesToOrder( 'Tax' );

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

		$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
		$persistenceManager->persistAll();

		$this->cart->setOrderId( $this->orderItem->getUid() );
	}

	/**
	 * @param $params
	 * @param $obj
	 * @return int
	 */
	public function afterSetOrderNumber( &$params, &$obj ) {
		$this->getObjectManager();

		$this->cart = $params['cart'];

		$orderId = $this->cart->getOrderId();
		$orderNumber = $this->cart->getOrderNumber();

		if ( empty( $orderId ) || empty( $orderNumber ) ) {
			return -1;
		}

		$this->getOrderItemRepository();
		/**
		 * @var $orderItem \Extcode\WtCartOrder\Domain\Model\OrderItem
		 */
		$orderItem = $this->orderItemRepository->findByUid( $orderId );

		$newOrderNumber = $orderItem->setOrderNumber( $orderNumber );

		if ( $newOrderNumber != $orderNumber) {
			$params['errors']['afterSetOrderNumber'] = 'Order Number can not be replaced.';
			if ( TYPO3_DLOG ) {
				\TYPO3\CMS\Core\Utility\GeneralUtility::devLog( $params['errors']['afterSetOrderNumber'], 'wt_cart_order', 0, array( 'orderNumber' => $orderNumber, 'newOrderNumber' => $newOrderNumber ) );
			}
			return -2;
		}

		$this->orderItemRepository->update($orderItem);

		$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
		$persistenceManager->persistAll();

		$files = array();
		$errors = array();

		$data = array(
			'orderItem' => $orderItem,
			'type' => 'order',
			'files' => &$files,
			'errors' => &$errors
		);

		$this->signalSlotDispatcher = $this->objectManager->get('\TYPO3\CMS\Extbase\SignalSlot\Dispatcher');
		$this->signalSlotDispatcher->dispatch( __CLASS__, 'slotAfterSaveOrderNumberToOrderItem', array( $data ) );

		\TYPO3\CMS\Core\Utility\GeneralUtility::devLog( 'afterSetOrderNumber', 'wt_cart_order', 0, array( 'data' => $data ) );

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
		$this->getObjectManager();

		$this->cart = $params['cart'];

		$orderId = $this->cart->getOrderId();
		$invoiceNumber = $this->cart->getInvoiceNumber();

		if ( empty( $orderId ) || empty( $invoiceNumber ) ) {
			return -1;
		}

		$this->getOrderItemRepository();
		/**
		 * @var $orderItem \Extcode\WtCartOrder\Domain\Model\OrderItem
		 */
		$orderItem = $this->orderItemRepository->findByUid( $orderId );

		$newInvoiceNumber = $orderItem->setInvoiceNumber( $invoiceNumber );

		if ( $newInvoiceNumber != $invoiceNumber) {
			$params['errors']['afterSetInvoiceNumber'] = 'Invoice Number can not be replaced.';
			if ( TYPO3_DLOG ) {
				\TYPO3\CMS\Core\Utility\GeneralUtility::devLog( $params['errors']['afterSetInvoiceNumber'], 'wt_cart_order', 0, array( 'invoiceNumber' => $invoiceNumber, 'newInvoiceNumber' => $newInvoiceNumber ) );
			}
			return -2;
		}

		$this->orderItemRepository->update($orderItem);

		$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
		$persistenceManager->persistAll();

		$files = array();
		$errors = array();

		$data = array(
			'orderItem' => $orderItem,
			'type' => 'invoice',
			'files' => &$files,
			'errors' => &$errors
		);

		$this->signalSlotDispatcher = $this->objectManager->get('\TYPO3\CMS\Extbase\SignalSlot\Dispatcher');
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
		$this->getObjectManager();

		$this->cart = $params['cart'];

		$orderId = $this->cart->getOrderId();

		$this->getOrderItemRepository();
		/**
		 * @var $orderItem \Extcode\WtCartOrder\Domain\Model\OrderItem
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

	protected function addTaxClasses() {
		$orderTaxClassRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderTaxClassRepository');

		$taxes = $this->parseWtCartTaxesFromConf($this->wtcart_conf);

		foreach ( $this->cart->getTotalTaxes() as $cartTaxKey => $cartTax) {
			$tax = $taxes[$cartTaxKey];
			/**
			 * @var $orderTaxClass \Extcode\WtCartOrder\Domain\Model\OrderTaxClass
			 */
			$orderTaxClass = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderTaxClass');
			$orderTaxClass->setPid( $this->storagePid );

			$orderTaxClass->setName( $tax['name'] );
			$orderTaxClass->setCalc( $tax['calc'] );
			$orderTaxClass->setValue( $tax['value'] );

			$orderTaxClassRepository->add( $orderTaxClass );

			$this->taxClass[ $tax['id'] ] = $orderTaxClass;
		}

		$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
		$persistenceManager->persistAll();
	}

	/**
	 * @param array $conf
	 * @return array $taxes
	 */
	protected function parseWtCartTaxesFromConf(&$conf) {
		$taxes = array();

		if ( isset($conf['taxClassRepository.']) && is_array($conf['taxClassRepository.'])) {
			$taxes = $this->parseTaxesFromRepository($conf);
		} elseif ( isset($conf['taxclass.']) && is_array($conf['taxclass.'])) {
			$taxes = $this->parseTaxesFromTypoScript($conf);
		}

		return $taxes;
	}

	/**
	 * @param array $conf
	 * @return array $taxes
	 */
	protected function parseTaxesFromTypoScript(&$conf) {
		$taxes = array();

		foreach ($conf['taxclass.'] as $key => $value) {
			$taxes[rtrim($key, '.')] = array(
				'id' => rtrim($key, '.'),
				'value' => $value['value'],
				'calc' => $value['calc'],
				'name' => $value['name']);
		}

		return $taxes;
	}

	/**
	 * @param array $conf
	 * @return array $taxes
	 */
	protected function parseTaxesFromRepository(&$conf) {
		$taxes = array();

		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		$taxClassRepository = $objectManager->get( $conf['taxClassRepository.']['class'] );
		$taxClassObjects = $taxClassRepository->findAll( );

		foreach ($taxClassObjects as $taxClassObject) {
			$taxes[$taxClassObject->getUid()] = array(
				'id' => $taxClassObject->getUid(),
				'value' => $taxClassObject->getValue(),
				'calc' => $taxClassObject->getCalc(),
				'name' => $taxClassObject->getTitle()
			);
		}

		return $taxes;
	}

	/**
	 *
	 */
	protected function addTaxesToOrder( $type = 'Tax') {
		$orderTaxRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderTaxRepository');

		$cartTaxes = call_user_func( array( $this->cart, 'get' . $type . 'es' ) );
		foreach ( $cartTaxes as $cartTaxKey => $cartTax) {
			/**
			 * @var $orderTax \Extcode\WtCartOrder\Domain\Model\OrderTax
			 */
			$orderTax = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderTax');
			$orderTax->setPid( $this->storagePid );

			$orderTax->setTax( $cartTax );
			$orderTax->setOrderTaxClass( $this->taxClass[ $cartTaxKey ] );

			$orderTaxRepository->add( $orderTax );

			call_user_func( array( $this->orderItem, 'addOrder' . $type ), $orderTax );
		}
	}

	/**
	 *
	 */
	protected function addShippingToOrder() {
		$shipping = $this->cart->getShipping();

		$orderTaxRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderTaxRepository');
		/**
		 * @var $orderTax \Extcode\WtCartOrder\Domain\Model\OrderTax
		 */
		$orderTax = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderTax');
		$orderTax->setPid( $this->storagePid );

		$orderTax->setTax( $shipping->getTax()->getTax() );
		$orderTax->setOrderTaxClass( $this->taxClass[ $shipping->getTaxClass()->getId() ] );

		$orderTaxRepository->add( $orderTax );

		$orderShippingRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderShippingRepository');
		/**
		 * @var $orderShipping \Extcode\WtCartOrder\Domain\Model\OrderShipping
		 */
		$orderShipping = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderShipping');
		$orderShipping->setPid( $this->storagePid );

		$orderShipping->setName( $shipping->getName() );
		$orderShipping->setStatus( $shipping->getStatus() );
		$orderShipping->setGross( $shipping->getGross( $this->cart ) );
		$orderShipping->setNet( $shipping->getNet( $this->cart ) );
		$orderShipping->setOrderTax( $orderTax );

		$orderShippingRepository->add( $orderShipping );

		$this->orderItem->setOrderShipping( $orderShipping );
	}

	/**
	 *
	 */
	protected function addPaymentToOrder() {
		$payment = $this->cart->getPayment();

		$orderTaxRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderTaxRepository');
		/**
		 * @var $orderTax \Extcode\WtCartOrder\Domain\Model\OrderTax
		 */
		$orderTax = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderTax');
		$orderTax->setPid( $this->storagePid );

		$orderTax->setTax( $payment->getTax()->getTax() );
		$orderTax->setOrderTaxClass( $this->taxClass[ $payment->getTaxClass()->getId() ] );

		$orderTaxRepository->add( $orderTax );

		$orderPaymentRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderPaymentRepository');

		/**
		 * @var $orderPayment \Extcode\WtCartOrder\Domain\Model\OrderPayment
		 */
		$orderPayment = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderPayment');
		$orderPayment->setPid( $this->storagePid );

		$orderPayment->setName( $payment->getName() );
		$orderPayment->setStatus( $payment->getStatus() );
		$orderPayment->setGross( $payment->getGross( $this->cart ) );
		$orderPayment->setNet( $payment->getNet( $this->cart ) );
		$orderPayment->setOrderTax( $orderTax );

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
		$orderTaxRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderTaxRepository');
		/**
		 * @var $orderTax \Extcode\WtCartOrder\Domain\Model\OrderTax
		 */
		$orderTax = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderTax');
		$orderTax->setPid( $this->storagePid );

		$orderTax->setTax( $cartProduct->getTax()->getTax() );
		$orderTax->setOrderTaxClass( $this->taxClass[ $cartProduct->getTaxClass()->getId() ] );

		$orderTaxRepository->add( $orderTax );

		$orderProductRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderProductRepository');

		/**
		 * @var $orderProduct \Extcode\WtCartOrder\Domain\Model\OrderProduct
		 */
		$orderProduct = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderProduct');
		$orderProduct->setPid( $this->storagePid );

		$orderProduct->setTitle( $cartProduct->getTitle() );
		$orderProduct->setSku( $cartProduct->getSku() );
		$orderProduct->setCount( $cartProduct->getQty() );
		$orderProduct->setPrice( $cartProduct->getPrice() );
		$orderProduct->setGross( $cartProduct->getGross() );
		$orderProduct->setNet( $cartProduct->getNet() );
		$orderProduct->setOrderTax( $orderTax );

		$additionalArray = $cartProduct->getAdditionalArray();

		$data = array(
			'cartProduct' => $cartProduct,
			'orderProduct' => &$orderProduct,
			'additionalArray' => &$additionalArray,
			'storagePid' => $this->storagePid,
		);

		$this->signalSlotDispatcher = $this->objectManager->get('\TYPO3\CMS\Extbase\SignalSlot\Dispatcher');
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

		$orderTaxRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderTaxRepository');
		/**
		 * @var \Extcode\WtCartOrder\Domain\Model\OrderTax $orderTax
		 */
		$orderTax = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderTax');
		$orderTax->setPid( $this->storagePid );

		$cartVariantTaxArray = $cartVariant->getTax();
		$orderTax->setTax( $cartVariantTaxArray['tax'] );
		$orderTax->setOrderTaxClass( $this->taxClass[ $cartVariant->getTaxClass()->getId() ] );

		$orderTaxRepository->add( $orderTax );

		$orderProductRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderProductRepository');
		$orderProductAdditionalRepository = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Repository\OrderProductAdditionalRepository');

		/**
		 * @var \Extcode\WtCartOrder\Domain\Model\OrderProduct $orderProduct
		 */
		$orderProduct = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderProduct');
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
		$orderProduct->setOrderTax( $orderTax );

		if ( ! $orderProduct->_isDirty() ) {
			$orderProductRepository->add($orderProduct);
		}

		$cartVariantInner = $cartVariant;
		for ( $count = $level; $count > 0; $count-- ) {
			/**
			 * @var \Extcode\WtCartOrder\Domain\Model\OrderProductAdditional $orderProductAdditional
			 */
			$orderProductAdditional = $this->objectManager->get('\Extcode\WtCartOrder\Domain\Model\OrderProductAdditional');
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

		$this->signalSlotDispatcher = $this->objectManager->get('\TYPO3\CMS\Extbase\SignalSlot\Dispatcher');
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
			$this->cObj = $this->objectManager->get( 'tslib_cObj' );
		}

		return $this->cObj;
	}

	/**
	 * Tell whether current CMS version is greater or equal than 6.0.
	 *
	 * @return bool
	 */
	protected function isVersionHigherOrEqualToVersionSix() {
		$version = class_exists('t3lib_utility_VersionNumber') ?
			t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) :
			TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);

		return $version >= 6000000;
	}

}

?>