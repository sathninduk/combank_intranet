/**
 * Plugin installation
 */
(function($, window, document, undefined){
    "use strict";

    $(function(){

        $('.voluto-install-now').on( 'click', function( event ) {
            var $button = $( event.target );
            event.preventDefault();

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }

            /**
             * Install a plugin
             *
             * @return void
             */
            function installPlugin($data){
                    globalAjax(
					$data['data-install-url'],
					'GET',
					{},
					function(){ // beforeSend callback
						buttonStatusInProgress( $data['data-installing-label']  );
					},
					function(){ // success callback
						buttonStatusInstalled( 'Installed' );
						activatePlugin($data);
					},
					function() { // error callback
						buttonStatusDisabled( 'Failed!' );
						return false;
					}
				);
            }

            /**
             * global AJAX callback
             */
            function globalAjax( _url, _type, _data, _beforeSendCallback, _successCallback, _errorCallback ) {
                $.ajax({
                    url: _url,
                    type: _type,
                    data: _data,
                    beforeSend: _beforeSendCallback,
                    success: _successCallback,
                    error: _errorCallback
                });
            }

            /**
             * Activate a plugin
             *
             * @return void
             */
            function activatePlugin( $data ){

                globalAjax(
                    $data['data-activate-url'],
                    'GET',
                    {},
                    function () { // beforeSend callback
                        buttonStatusInProgress( $data['data-activating-label'] );
                    },
                    function () { // success callback
                        buttonStatusDisabled( 'Installation completed' );
                        run( $data['data-plugin-order'] );
                    },
                    function (xhr) {
                        buttonStatusDisabled( 'Something went wrong.' );
                        return false;
                    }
                );

            }

            /**
             * Change button status to in-progress
             *
             * @return void
             */
            function buttonStatusInProgress( message ){
                $button.addClass('updating-message').removeClass('button-disabled voluto-pi-not-installed installed').text( message );
            }

            /**
             * Change button status to disabled
             *
             * @return void
             */
            function buttonStatusDisabled( message ){
                $button.removeClass('updating-message voluto-pi-not-installed installed')
                        .addClass('button-disabled')
                        .text( message );
            }

            /**
             * Change button status to installed
             *
             * @return void
             */
            function buttonStatusInstalled( message ){
                $button.removeClass('updating-message voluto-pi-not-installed')
                        .addClass('installed')
                        .text( message );
            }

            const $plugins_info = $button.data('info');
            function run($key = 0) {
                if (typeof $plugins_info[$key] == 'undefined' || $plugins_info[$key]['data-plugin-order'] > $plugins_info[0]['data-num-of-required-plugins'] ) {
                    location.replace( $plugins_info[$plugins_info.length - 1]['data-redirect-url'] );
                    return;
                }

                let $this = $plugins_info[$key];
                if( $this['data-action'] === 'install' ){
                    installPlugin($this);
                } else if( $this['data-action'] === 'activate' ){
                    activatePlugin($this);
                }

            }
            run();

        });

    });

})(jQuery, window, document);