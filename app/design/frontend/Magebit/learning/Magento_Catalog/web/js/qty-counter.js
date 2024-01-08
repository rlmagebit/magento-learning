define([
    'uiComponent',
    'ko'
], function (Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magento_Catalog/input-counter',
            qty: 1
        },

        initialize: function () {
            this._super();
            this.qty = ko.observable(this.qty);
            return this;
        },

        increaseQty: function () {
            this.qty(this.qty() + 1);
        },

        decreaseQty: function () {
            if (this.qty() > 1) {
                this.qty(this.qty() - 1);
            }
        }
    });
});
