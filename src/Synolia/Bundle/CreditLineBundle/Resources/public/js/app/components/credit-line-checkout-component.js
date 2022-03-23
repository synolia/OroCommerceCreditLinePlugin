define(function(require) {
    'use strict';

    const _ = require('underscore');
    const mediator = require('oroui/js/mediator');
    const BaseComponent = require('oroui/js/app/components/base/component');
    const routing = require('routing');

    const CreditLineMethodComponent = BaseComponent.extend({
        /**
         * @property {Object}
         */
        options: {
            paymentMethod: null,
            successUrl: ''
        },

        /**
         * @inheritDoc
         */
        constructor: function CreditLineMethodComponent(options) {
            CreditLineMethodComponent.__super__.constructor.call(this, options);
        },

        /**
         * @inheritDoc
         */
        initialize: function(options) {
            this.options = _.defaults(options || {}, this.options);

            mediator.on('checkout:place-order:response', this.handleSubmit, this);
        },

        /**
         * @param {Object} eventData
         */
        handleSubmit: function(eventData) {
            if (eventData.responseData.paymentMethod === this.options.paymentMethod) {
                eventData.stopped = true;

                const responseData = _.extend({successUrl: this.getSuccessUrl()}, eventData.responseData);

                if (responseData.isSuccess) {
                    mediator.execute('redirectTo', {url: responseData.successUrl}, {redirect: true});
                    return;
                }

                mediator.execute('redirectTo', {url: eventData.responseData.errorUrl}, {redirect: true});
            }
        },

        getSuccessUrl: function() {
            if (this.options.successUrl) {
                return routing.generate(this.options.successUrl);
            }

            return null;
        },

        dispose: function() {
            if (this.disposed) {
                return;
            }

            mediator.off('checkout:place-order:response', this.handleSubmit, this);

            CreditLineMethodComponent.__super__.dispose.call(this);
        }
    });

    return CreditLineMethodComponent;
});
