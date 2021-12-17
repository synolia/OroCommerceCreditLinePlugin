define(function(require) {
    'use strict';

    const mediator = require('oroui/js/mediator');
    const messenger = require('oroui/js/messenger');
    const __ = require('orotranslation/js/translator');
    const _ = require('underscore');
    const BaseComponent = require('oroui/js/app/components/base/component');

    const CreditLineTransitionButtonComponent = BaseComponent.extend({
        /**
         * @inheritDoc
         */
        initialize: function(options) {
            this.options = _.extend({}, this.options, options);

            mediator.on('checkout:payment:before-transit', this.beforeTransit, this);
        },

        /**
         * @inheritDoc
         */
        dispose: function() {
            if (this.disposed || !this.disposable) {
                return;
            }

            this.$el.off();

            mediator.off('checkout:payment:before-transit', this.beforeTransit, this);

            CreditLineTransitionButtonComponent.__super__.dispose.call(this);
        },

        /**
         * @inheritDoc
         */
        beforeTransit: function(eventData) {
            if (
                eventData.data.paymentMethod === this.options.paymentMethod &&
                this.options.syCreditLine < this.options.totalValue
            ) {
                eventData.stopped = true;

                messenger.notificationFlashMessage(
                    'warning',
                    __('synolia.frontend.payment_method.checkout.balance_payment.unsufficient_balance.label')
                );
            }
        }
    });

    return CreditLineTransitionButtonComponent;
});
