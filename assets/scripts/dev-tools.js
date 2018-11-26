(function ($) {

    function FewbricksDevHelper() {

        var $this = this;

        /**
         *
         */
        this.init = function() {

            $this.cssClassFull = 'fewbricks-dev-tools--full';

            $this.initMailElm();
            $this.initToggler();

        }

        this.initMailElm = function() {

            $this.$mainElm = $('#fewbricks-dev-tools');

        }

        this.initToggler = function() {

            $('.fewbricks-dev-tools__toggler')
                .unbind('click')
                .on('click', function() {

                    $this.toggleMainElm($(this).attr('data-height'));

                });

        }

        /**
         *
         */
        this.toggleMainElm = function(height) {

            if(height === 'minimized') {

                $this.$mainElm.attr('style', function(i, style)
                {
                    return style && style.replace(/height[^;]+;?/g, '');
                });

            } else {
                $this.$mainElm.height(height + 'vh');
            }

        }

        /**
         *
         * @returns {*|boolean}
         */
        this.mainElmIsFull = function() {

            return $this.$mainElm.hasClass($this.cssClassFull);

        }

    }

    $(document).ready(function () {

        (new FewbricksDevHelper()).init();

    });
})(jQuery);
