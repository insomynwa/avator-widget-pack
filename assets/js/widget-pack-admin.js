jQuery(document).ready(function ($) {

    jQuery('.widget-pack-notice.is-dismissible .notice-dismiss').on('click', function () {
        $this = jQuery(this).parents('.widget-pack-notice');
        var $id = $this.attr('id') || '';
        var $time = $this.attr('dismissible-time') || '';
        var $meta = $this.attr('dismissible-meta') || '';

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'widget-pack-notices',
                id: $id,
                meta: $meta,
                time: $time,
            },
        });

    });

});