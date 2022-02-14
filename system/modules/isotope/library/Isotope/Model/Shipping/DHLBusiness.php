<?php

/*
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009 - 2019 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @link       https://isotopeecommerce.org
 * @license    https://opensource.org/licenses/lgpl-3.0.html
 */

namespace Isotope\Model\Shipping;

use Isotope\Model\ProductCollection\Order;

/**
 * @property string $dhl_user
 * @property string $dhl_signature
 * @property string $dhl_epk
 * @property string $dhl_product
 * @property string $dhl_app
 * @property string $dhl_token
 * @property array  $dhl_shipping
 */
class DHLBusiness extends Flat
{
    /**
     * @inheritDoc
     */
    public function isAvailable()
    {
        return parent::isAvailable() && class_exists('error08\DHL\BusinessShipment');
    }
    /**
     * @inheritdoc
     */
    public function backendInterface($orderId)
    {
     if (($objOrder = Order::findByPk($orderId)) === null) {
         return parent::backendInterface($orderId);
     }

     $arrShipping = deserialize($objOrder->shipping_data, true);

     if (empty($arrShipping['dhl_shipment_number'])) {
         return parent::backendInterface($orderId);
     }
     $statusCode = $arrShipping['dhl_shipment_statusCode'];
     $strBuffer = '
         <div id="tl_buttons">
         <a href="' . ampersand(str_replace('&key=shipping', '', \Environment::get('request'))) . '" class="header_back" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['backBT']) . '">' . $GLOBALS['TL_LANG']['MSC']['backBT'] . '</a>
         </div>

         <h2 class="sub_headline">' . $this->name . ' (' . $GLOBALS['TL_LANG']['MODEL']['tl_iso_shipping']['dhl_business'][0] . ')</h2>

         <div id="tl_messages">
           <p class="tl_info">'.$GLOBALS['TL_LANG']['MSC']['dhlTrackingnumber']. ': '. $arrShipping['dhl_shipment_number'].'</p>
           <p class="'.print_r($statusCode == 0 ? 'tl_info' : 'tl_error',true).'">'. $statusCode .' ('.$arrShipping['dhl_shipment_statusText'].') - '.$arrShipping['dhl_shipment_statusMessage'].'</p>
         </div>
         <a href="'.$arrShipping['dhl_shipment_label'].'" target="_blank">
            <button type="button" name="openLabel" id="openLabel" class="tl_submit" accesskey="c">'.$GLOBALS['TL_LANG']['MSC']['dhlLabelOnline'].'</button>
         </a>
         <!--
         <a href="'.$arrShipping['dhl_shipment_label'].'" target="_blank">
             <button type="button" name="deleteLabel" id="deleteLabel" class="tl_submit" accesskey="c">'.$GLOBALS['TL_LANG']['MSC']['dhlDeleteLabel'].'</button>
          </a>
          -->
         <pre>'.print_r($arrShipping['dhl_shipment_order'],true).'</pre>
         </div>';

                 return $strBuffer;
        }
        public function deleteShipmentLabel($orderId)
        {
             if (($objOrder = Order::findByPk($orderId)) === null) {
                 return;
             }
             $arrShipping = deserialize($objOrder->shipping_data, true);
             $shipping = $objOrder->getShippingMethod();

             if (!$objOrder instanceof Order
                 || !$shipping instanceof DHLBusiness
             ) {
                 return;
             }

             $dhl = new BusinessShipment($this->getCredentials($shipping), (bool) $shipping->debug);
             $response = $dhl->deleteShipment($arrShipping['dhl_shipment_number']);

             if ($shipping->logging) {
                 log_message(print_r($dhl->getLastXML(), true), 'isotope_dhl_business.log');
                 log_message(print_r($response, true), 'isotope_dhl_business.log');
             }
        }
        private function getCredentials(DHLBusiness $shipping)
            {
                $credentials = new Credentials((bool) $shipping->debug);

                $credentials->setUser($shipping->dhl_user);
                $credentials->setSignature($shipping->dhl_signature);
                $credentials->setEpk($shipping->dhl_epk);
                $credentials->setApiUser($shipping->dhl_app);
                $credentials->setApiPassword($shipping->dhl_token);

                if ($shipping->logging) {
                    log_message(print_r($credentials, true), 'isotope_dhl_business.log');
                }

                return $credentials;
            }
}
