define([
    'jquery',
    'Magento_Payment/js/view/payment/cc-form'
],
function ($, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'ISN_OnlinePayment/payment/onlinepayments'
        },

        context: function() {
            return this;
        },

        getCode: function() {
            return 'isn_onlinepayment';
        },

        isActive: function() {
            return true;
        }
    });
}
);