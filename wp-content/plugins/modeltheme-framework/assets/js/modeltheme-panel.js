/* global _NFTMarketplace, tb_click */

/**
 * Envato Market sripts.
 *
 * @since 1.0.0
 */
(function( $ ) {
  'use strict';
  var dialog, NFTMarketplace = {

    cache: {},

    init: function() {
      this.bindEvents();
    },

    bindEvents: function() {
      var self = this;

      self.addItem();
      self.removeItem();
      self.tabbedNav();

      $( document ).on( 'click', '.card a.thickbox', function() {
        tb_click.call( this );
        $( '#TB_title' ).css({ 'background-color': '#23282d', 'color': '#cfcfcf' });
        return false;
      });
    },

    addItem: function() {
      $( document ).on( 'click', '.add-nft-marketplace-core-panel-item', function( event ) {
        var id = 'nft-marketplace-core-panel-dialog-form';
        event.preventDefault();

        if ( 0 === $( '#' + id ).length ) {
          $( 'body' ).append( wp.template( id ) );
        }

        dialog = $( '#' + id ).dialog({
          autoOpen: true,
          modal: true,
          width: 350,
          buttons: {
            Save: {
              text: _NFTMarketplace.i18n.save,
              click: function() {
                var form = $( this ),
                  request, token, input_id;

                form.on( 'submit', function( event ) {
                  event.preventDefault();
                });

                token = form.find( 'input[name="token"]' ).val();
                input_id = form.find( 'input[name="id"]' ).val();

                request = wp.ajax.post( _NFTMarketplace.action + '_add_item', {
                  nonce: _NFTMarketplace.nonce,
                  token: token,
                  id: input_id
                });

                request.done(function( response ) {
                  var item = wp.template( 'nft-marketplace-core-panel-item' ),
                    card = wp.template( 'nft-marketplace-core-panel-card' ),
                    button = wp.template( 'nft-marketplace-core-panel-auth-check-button' );

                  $( '.nav-tab-wrapper' ).find( '[data-id="' + response.type + '"]' ).removeClass( 'hidden' );

                  response.item.type = response.type;
                  $( '#' + response.type + 's' ).append( card( response.item ) ).removeClass( 'hidden' );

                  $( '#nft-marketplace-core-panel-items' ).append( item({
                    name: response.name,
                    token: response.token,
                    id: response.id,
                    key: response.key,
                    type: response.type,
                    authorized: response.authorized
                  }) );

                  if ( 0 === $( '.auth-check-button' ).length ) {
                    $( 'p.submit' ).append( button );
                  }

                  dialog.dialog( 'close' );
                  NFTMarketplace.addReadmore();
                });

                request.fail(function( response ) {
                  var template = wp.template( 'nft-marketplace-core-panel-dialog-error' ),
                    data = {
                      message: ( response.message ? response.message : _NFTMarketplace.i18n.error )
                    };

                  dialog.find( '.notice' ).remove();
                  dialog.find( 'form' ).prepend( template( data ) );
                  dialog.find( '.notice' ).fadeIn( 'fast' );
                });
              }
            },
            Cancel: {
              text: _NFTMarketplace.i18n.cancel,
              click: function() {
                dialog.dialog( 'close' );
              }
            }
          },
          close: function() {
            dialog.find( '.notice' ).remove();
            dialog.find( 'form' )[0].reset();
          }
        });
      });
    },

    removeItem: function() {
      $( document ).on( 'click', '#nft-marketplace-core-panel-items .item-delete', function( event ) {
        var self = this, id = 'nft-marketplace-core-panel-dialog-remove';
        event.preventDefault();

        if ( 0 === $( '#' + id ).length ) {
          $( 'body' ).append( wp.template( id ) );
        }

        dialog = $( '#' + id ).dialog({
          autoOpen: true,
          modal: true,
          width: 350,
          buttons: {
            Save: {
              text: _NFTMarketplace.i18n.remove,
              click: function() {
                var form = $( this ),
                  request, id;

                form.on( 'submit', function( submit_event ) {
                  submit_event.preventDefault();
                });

                id = $( self ).parents( 'li' ).data( 'id' );

                request = wp.ajax.post( _NFTMarketplace.action + '_remove_item', {
                  nonce: _NFTMarketplace.nonce,
                  id: id
                });

                request.done(function() {
                  var item = $( '.col[data-id="' + id + '"]' ),
                    type = item.find( '.envato-card' ).hasClass( 'theme' ) ? 'theme' : 'plugin';

                  item.remove();

                  

                  $( self ).parents( 'li' ).remove();

                  $( '#nft-marketplace-core-panel-items li' ).each(function( index ) {
                    $( this ).find( 'input' ).each(function() {
                      $( this ).attr( 'name', $( this ).attr( 'name' ).replace( /\[\d\]/g, '[' + index + ']' ) );
                    });
                  });

                  if ( 0 !== $( '.auth-check-button' ).length && 0 === $( '#nft-marketplace-core-panel-items li' ).length ) {
                    $( 'p.submit .auth-check-button' ).remove();
                  }

                  dialog.dialog( 'close' );
                });

                request.fail(function( response ) {
                  var template = wp.template( 'nft-marketplace-core-panel-dialog-error' ),
                    data = {
                      message: response.message ? response.message : _NFTMarketplace.i18n.error
                    };

                  dialog.find( '.notice' ).remove();
                  dialog.find( 'form' ).prepend( template( data ) );
                  dialog.find( '.notice' ).fadeIn( 'fast' );
                });
              }
            },
            Cancel: {
              text: _NFTMarketplace.i18n.cancel,
              click: function() {
                dialog.dialog( 'close' );
              }
            }
          }
        });
      });
    },

    tabbedNav: function() {
      var self = this,
        $wrap = $( '.modeltheme-panel-wrapper' );

      // Hide all panels
      $( 'div.panel', $wrap ).hide();

      var tab = self.getParameterByName( 'tab' ),
        hashTab = window.location.hash.substr( 1 );

      // Listen for the click event.
      $( document, $wrap ).on( 'click', '.nav-tab-container a', function() {

        // Deactivate and hide all tabs & panels.
        $( '.nav-tab-container a', $wrap ).removeClass( 'nav-tab-active' );
        $( 'div.panel', $wrap ).hide();

        // Activate and show the selected tab and panel.
        $( this ).addClass( 'nav-tab-active' );
        $( 'div' + $( this ).attr( 'href' ), $wrap ).show();

        self.maybeLoadhealthcheck();

        return false;
      });

      if ( tab ) {
        $( '.nav-tab-container a[href="#' + tab + '"]', $wrap ).click();
      } else if ( hashTab ) {
        $( '.nav-tab-container a[href="#' + hashTab + '"]', $wrap ).click();
      } else {
        $( 'div.panel:not(.hidden)', $wrap ).first().show();
      }

    },

    getParameterByName: function( name ) {
      var regex, results;
      name = name.replace( /[\[]/, '\\[' ).replace( /[\]]/, '\\]' );
      regex = new RegExp( '[\\?&]' + name + '=([^&#]*)' );
      results = regex.exec( location.search );
      return null === results ? '' : decodeURIComponent( results[1].replace( /\+/g, ' ' ) );
    },

    maybeLoadhealthcheck: function() {
      // We only load the health check ajax call when the nft-marketplace-core-panel-healthcheck div is visible on the page.
      var $healthCheckOutput = $( '.nft-marketplace-core-panel-healthcheck' );
      if( $healthCheckOutput.is( ':visible') ) {
        $healthCheckOutput.text('Loading...');

        // Use our existing wp.ajax.post pattern from above to call the healthcheck API endpoint
        var request = wp.ajax.post( _NFTMarketplace.action + '_healthcheck', {
          nonce: _NFTMarketplace.nonce
        });

        request.done(function( response ) {
          if( response && response.limits ) {
            var $healthCheckUL = $( '<ul></ul>' );
            var limits = Object.keys( response.limits );
            for( var i = 0; i < limits.length; i++ ) {
              var $healthCheckLI = $( '<li></li>' );
              var healthCheckItem = response.limits[limits[i]];
              $healthCheckLI.addClass( healthCheckItem.ok ? 'healthcheck-ok' : 'healthcheck-error' );
              $healthCheckLI.attr( 'data-limit', limits[i] );
              $healthCheckLI.append( '<span class="healthcheck-item-title">' + healthCheckItem.title + '</span>' );
              $healthCheckLI.append( '<span class="healthcheck-item-message">' + healthCheckItem.message + '</span>' );
              $healthCheckUL.append( $healthCheckLI );
            }
            $healthCheckOutput.html( $healthCheckUL );
          }else{
            window.console.log( response );
            $healthCheckOutput.text('Health check failed to load. Please check console for errors.');
          }
        });

        request.fail(function( response ) {
          window.console.log( response );
          $healthCheckOutput.text('Health check failed to load. Please check console for errors.');
        });
      }
    }

  };

  $( window ).on('load', function() {
    NFTMarketplace.init();
  });

  
})( jQuery );
