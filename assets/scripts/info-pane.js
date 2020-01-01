(function ($) {

    function FewbricksDevHelper() {

        var $this = this;

        /**
         *
         */
        this.init = function() {

            $this.cssClassFull = 'fewbricks-info-pane--full';

            $this.initMailElm();
            $this.initToggler();

        }

        this.initMailElm = function() {

            $this.$mainElm = $('#fewbricks-info-pane');

            if(typeof fewbricksInfoPane !== 'undefined' && typeof fewbricksInfoPane.startHeight !== 'undefined') {
                $this.toggleMainElm(fewbricksInfoPane.startHeight);
            }

        }

        this.initToggler = function() {

            $('.fewbricks-info-pane__toggler')
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
