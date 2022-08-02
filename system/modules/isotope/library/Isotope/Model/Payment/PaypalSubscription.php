<?php

/*
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009 - 2019 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @link       https://isotopeecommerce.org
 * @license    https://opensource.org/licenses/lgpl-3.0.html
 */

namespace Isotope\Model\Payment;

use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopePurchasableCollection;
use Isotope\Model\Payment;


/**
 * Class PaypalSubscription
 *
 * Handle paypal subscriptions
 * @copyright  Isotope eCommerce Workgroup 2009-2012
 * @author     Lars Pinnow <info.lpsoft.de>
 */
class PaypalSubscription extends Payment
{
    /**
     * @inheritdoc
     */
    public function processPayment(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        if (!$objOrder instanceof IsotopePurchasableCollection) {
            return false;
        }

        $objOrder->checkout();
        $objOrder->updateOrderStatus($this->new_order_status);

        return true;
    }

    /**
     * Return a html form for checkout or false
     *
     * @param IsotopeProductCollection $objOrder  The order being places
     * @param \Module                  $objModule The checkout module instance
     *
     * @return bool
     */
    public function checkoutForm(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        $client_id_ts = "AeN5_V99fTPkfyyZTTTnysCXmR6EVq-6amhgw5bS-Ad6gsgcfE53KT4y8sDNTeYrvgUHs2vPHYn5rDoi";
        $plan_id_ts = "P-46B8731548761714VMI5FHXI";
        $client_id_pr = "AQ_rv7jkqJWo5nQnZiy11Hh5ccUMEJ2nRjnYmUwPVEAEBM7tbNAwjhikZoM54ilLDkC0SXmwXfvClj_q";
        $plan_id_pr = "P-4V842355FP752450JMIZ2IHQ";
        $client_id = $client_id_ts;
        $plan_id = $plan_id_ts;
        return "<div id=\"paypal-button-container\"></div>
<script src=\"https://www.paypal.com/sdk/js?client-id=AeN5_V99fTPkfyyZTTTnysCXmR6EVq-6amhgw5bS-Ad6gsgcfE53KT4y8sDNTeYrvgUHs2vPHYn5rDoi&vault=true&intent=subscription\" data-sdk-integration-source=\"button-factory\"></script>
<script>
    paypal.Buttons({
      style: {
        shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: 'P-46B8731548761714VMI5FHXI'
        });
      },
      onApprove: function(data, actions) {
        alert(data.subscriptionID); // You can add optional success message for the subscriber here
    }
  }).render('#paypal-button-container'); // Renders the PayPal button
</script>";
    }
}
