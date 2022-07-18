define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
],
function (Component, rendererList) {
    'use strict';

    rendererList.push(
        {
            type: 'isn_onlinepayment',
            component: 'ISN_OnlinePayment/js/view/payment/method-renderer/onlinepayment'
        }
    );

    /** Add view logic here if needed */
    return Component.extend({});
});