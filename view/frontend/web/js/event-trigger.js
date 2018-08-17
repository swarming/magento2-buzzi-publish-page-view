/**
 * Copyright © Swarming Technology, LLC. All rights reserved.
 */

define([
    'jquery',
    'uiComponent',
    'Buzzi_Publish/js/action/send-event'
], function ($, Component, sendEvent) {
    'use strict';

    return Component.extend({
        defaults: {
            event_type: null,
            page_id: null,
            site_id: null,
            category: null
        },

        initialize: function () {
            this._super();

            if (this.event_type && this.page_id && this.site_id) {
                this.triggerEvent();
            }
        },

        triggerEvent: function () {
            var eventKey = this.site_id + ':' + this.page_id;
            if (this.category) {
                eventKey += ':' + eventKey;
            }

            sendEvent(
                this.event_type,
                {
                    page_id: this.page_id,
                    site_id: this.site_id,
                    category: this.category
                },
                eventKey
            );
        }
    });
});
