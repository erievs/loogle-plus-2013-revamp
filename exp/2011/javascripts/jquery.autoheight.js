// jquery autoheight textarea auto height function)
// @version 1.0.0
// @copyright 2011 Andras Barthazi

(function($) {
    $.fn.autoheight = function(options) {
        var options = $.extend({
            extra: 20
        }, options);
        this.filter('textarea').each(function(){
            var object = $(this).css({resize:'none','overflow-y':'hidden'});
            var orig = object.height();
            var props = {position:'absolute',top:0,left:-1978};
            $.each(['width','letterSpacing','lineHeight','textDecoration'], function(i, p){
                props[p] = object.css(p);
            });
            var clone = object.clone().removeAttr('id').removeAttr('name').css(props).attr('tabIndex','-1').insertBefore(object);
            $(this).add(clone);
            function resize() {
                clone.height(0).val($(this).val()).scrollTop(12345);
                object.height(Math.max(clone.scrollTop(), Math.max(orig, options.minimum)) + options.extra);
            }
            object
                .unbind('.autoheight').bind('focus.autoheight keyup.autoheight keydown.autoheight change.autoheight', resize)
                .blur(function(){ if ($(this).val() == '') $(this).height(orig); });
        });
        return this;
    };
})(jQuery);
