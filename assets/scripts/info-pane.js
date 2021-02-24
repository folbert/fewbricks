(function ($) {

    function FewbricksDevHelper() {

        var $this = this;

        /**
         *
         */
        this.init = function() {

            $this.cssClassFull = 'fewbricks-info-pane--full';

            if(!$this.initMainElm()) {
                return;
            }

            $this.initToggler();

            $this.$mainElm.show();

        }

        /**
         *
         */
        this.initMainElm = function() {

            $this.$mainElm = $('#fewbricks-info-pane');

            if($this.$mainElm.length === 0) {
                return false;
            }

            if(typeof fewbricksInfoPane !== 'undefined' && typeof fewbricksInfoPane.startHeight !== 'undefined') {
                $this.toggleMainElm(fewbricksInfoPane.startHeight);
            }

            return true;

        }

        /**
         *
         */
        this.initToggler = function() {

            $('[data-fewbricks-info-pane-toggler]')
                .unbind('click')
                .on('click', function() {

                    let height = $(this).attr('data-fewbricks-info-pane-height');

                    $this.toggleMainElm(height);

                    document.cookie = 'fewbricks_info_pane_height=' + height;

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
