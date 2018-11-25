(function ($) {

    function FewbricksDevHelper() {

        var $this = this;

        /**
         *
         */
        this.init = function() {

            $this.cssClassFull = 'fewbricks-dev-info--full';

            $this.initMailElm();
            $this.initToggler();

        }

        this.initMailElm = function() {

            $this.$mainElm = $('#fewbricks-dev-info');

        }

        this.initToggler = function() {

            $('#fewbricks-dev-info__full-toggler')
                .unbind('click')
                .on('click', function() {

                    $this.toggleMainElm();

                    if($this.mainElmIsFull()) {
                        $(this).text($(this).attr('data-contract-text'));
                    } else {
                        $(this).text($(this).attr('data-expand-text'));
                    }

                });

        }

        /**
         *
         */
        this.toggleMainElm = function() {

            if($this.$mainElm.hasClass($this.cssClassFull)) {
                $this.$mainElm.removeClass($this.cssClassFull);
            } else {
                $this.$mainElm.addClass($this.cssClassFull);
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
