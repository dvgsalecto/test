define([
    'underscore',
    'ko',
    'uiComponent',
    'jquery'
], function (_, ko, Component, $) {
    return Component.extend({

        initialize: function () {
            this._super();
    
            setInterval(function () {
                var isShowWarning = false;
    
                _.each($('[name$="attribute_scope]"]'), function (elem) {
                    if ($(elem).val() != '') {
                        isShowWarning = true;
                    }
                });
    
                if (isShowWarning) {
                    $('.mst-admin__field-warning').show();
                } else {
                    $('.mst-admin__field-warning').hide();
                }
            }, 500);

            return this;
        }
    });
});
