;(function ($, window, document, undefined) {

    //enable strict mode
    "use strict";

    var pluginName = 'simpleAccordion',
        defaults = {
            multiple: false,
            speedOpen: 300,
            speedClose: 150,
            easingOpen: null,
            easingClose: null,
            headClass: ['accordion-header'],
            bodyClass: 'accordion-body',
            openClass: 'open',
            defaultOpenClass: 'default-open',
            cbClose: null, //function (e, $this) {},
            cbOpen: null //function (e, $this) {}
        };

    // plugin constructor
    function Accordion(element, options) {
        this.$el = $(element);

        //merge passed options with defaults
        this.options = $.extend({}, defaults, options);

        //store original defaults in instance
        this._defaults = defaults;

        //store plugin name in instance
        this._name = pluginName;

        //if data-multiple is defined on element, merge with options
        if (typeof this.$el.data('multiple') !== 'undefined') {
            this.options.multiple = this.$el.data('multiple');
        } else {
            this.options.multiple = this._defaults.multiple;
        }

        //initialize plugin
        this.init();
    }

    //prototype functions
    Accordion.prototype = {
        init: function () {

            var o = this.options,
                $headings = this.$el.children('.' + o.headClass);

            //bind click on headings
            $headings.on('click', {_t:this}, this.headingClick);

            //open first default open
            $headings.filter('.' + o.defaultOpenClass).first().click();
        },
        headingClick: function (e) {
            var $this = $(this),
                _t = e.data._t,
                o = _t.options,
                $headings = _t.$el.children('.' + o.headClass),
                $currentOpen = $headings.filter('.' + o.openClass);

            if (!$this.hasClass(o.openClass)) {
                //are there any other open and is multiple option set to false
                if ($currentOpen.length && o.multiple === false) {
                    //if so, slide them up then slide the new one down
                    $currentOpen.removeClass(o.openClass).next('.' + o.bodyClass).slideUp(o.speedClose, o.easingClose, function () {
                        if ($.isFunction(o.cbClose)) {
                            o.cbClose(e, $currentOpen);
                        }
                        $this.addClass(o.openClass).next('.' + o.bodyClass).slideDown(o.speedOpen, o.easingOpen, function () {
                            if ($.isFunction(o.cbOpen)) {
                                o.cbOpen(e, $this);
                            }
                        });
                    });
                } else {//else just slide down
                    $this.addClass(o.openClass).next('.' + o.bodyClass).slideDown(o.speedOpen, o.easingOpen, function () {
                        $this.removeClass(o.defaultOpenClass);
                        if ($.isFunction(o.cbOpen)) {
                            o.cbOpen(e, $this);
                        }
                    });
                }
            } else {
                $this.removeClass(o.openClass).next('.' + o.bodyClass).slideUp(o.speedClose, o.easingClose, function () {
                    if ($.isFunction(o.cbClose)) {
                        o.cbClose(e, $this);
                    }
                });
            }

        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                    new Accordion(this, options));
            }
        });
    };

}(jQuery, window, document));
