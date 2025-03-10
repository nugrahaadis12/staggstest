jQuery( function( $ ) {

	var args 		= {},
		allPv 		= 0,
		nonce 		= $( '.mt-wizard' ).attr( 'data-nonce' ),
		progress 	= $( '.wizard-progress div' ),
		importerAJAX = null,
		timeout 	= 0,
		importerDone = function( hasError ) {

			if ( ! hasError ) {
				progress.css( 'width', '99%' ).find( 'span' ).html( '99%' );
			}

			setTimeout( function() {

				$( 'body' ).removeClass( 'mt-importing' );
				$( '.mt-demo-image' ).css( 'opacity', '1' );
				$( '.wizard-next' ).trigger( 'click' );

				if ( ! hasError ) {
					$( '.demo-error' ).hide();
					$( '.demo-success' ).show();
				}

				$( '.wizard-progress, .mt-back-button, .importer-spinner, .wizard-footer' ).hide();

			}, 1500 );

		},
		importerError = function( message ) {

			importerDone( true );

			$( '.demo-success' ).hide();
			$( '.demo-error' ).show().find( 'p' ).html( message );

		},
		inViewport = function( e, offset ) {

			var offset 			= offset || 0,
				docViewTop 		= $( window ).scrollTop(),
				docViewBottom 	= docViewTop + $( window ).height(),
				elemTop 		= e.offset().top,
				elemBottom 		= elemTop + e.height();

			return ( ( elemTop <= docViewBottom + offset ) && ( elemBottom >= docViewTop - offset ) );

		},
		progressBar = function( li, allPv, images ) {

			var current = parseFloat( progress.attr( 'data-current' ) );

			if ( images ) {
				var value = ( current + ( ( 100 - allPv ) / images ) );
			} else {
				var value = ( current + ( parseFloat( li.attr( 'data-pv' ) ) * ( 100 / allPv ) ) );
			}

			if ( value > 99 ) {
				value = 99;
			}

			progress.css( 'width', Math.round( value ) + '%' ).attr( 'data-current', value ).find( 'span' ).html( Math.round( value ) + '%' );

		};

		function attachment_importer( xml, li, startCurrent ) {

			var number = 0,
				attachments = {},
				failedAttachments = 0,
				failedAttachments2 = 0,
				importedNumber = 0,
				imageName = $( 'li[data-name="images"] b' );

			$( $.parseXML( xml ) ).find( 'item' ).each( function( k, v ) {

				var $this = $( this ),
					post_type = $this.find( 'wp\\:post_type, post_type' ).text();

				// We're only looking for images.
				if ( post_type == 'attachment' ) {

					attachments[ number++ ] = {

						url: $this.find( 'wp\\:attachment_url, attachment_url' ).text(),
						post_title: $this.find( 'title' ).text(),
						link: $this.find( 'link' ).text(),
						pubDate: $this.find( 'pubDate' ).text(),
						guid: $this.find( 'guid' ).text(),
						import_id: $this.find( 'wp\\:post_id, post_id' ).text(),
						post_date: $this.find( 'wp\\:post_date, post_date' ).text(),
						post_date_gmt: $this.find( 'wp\\:post_date_gmt, post_date_gmt' ).text(),
						post_name: $this.find( 'wp\\:post_name, post_name' ).text(),
						post_status: $this.find( 'wp\\:status, status' ).text(),
						post_parent: $this.find( 'wp\\:post_parent, post_parent' ).text(),
						post_type: post_type,

					};

				}

			});

			var max = Object.keys( attachments ).length;

			function import_attachments( i ) {

				imageName.html( '(' + ( i + 1 ) + ' ' + mtWizard.of + ' ' + max + ')' );

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'attachment_importer_upload',
						nonce: nonce,
						attachment: attachments[i]
					}
				}).done( function( data, status, xhr ) {

					var obj = JSON.parse( data );

					//console.log( obj );

					// If error shows the server did not respond, try again.
					if( obj.message == "Remote server did not respond" && failedAttachments < 3 ){

						failedAttachments++;

						imageName.html( '(' + ( i + 1 ) + ' ' + mtWizard.of + ' ' + max + ')' );

						setTimeout( function() {
							import_attachments( i );
						}, 5000 );

					// If a non-fatal error occurs, note it and move on.
					} else if( obj.type == "error" && !obj.fatal ) {

						progressBar( li, startCurrent, max );

						next_image( i );

					// Fatal error.
					} else if( obj.fatal ) {

						importerError( obj.text );

						return false;

					} else {

						progressBar( li, startCurrent, max );

						importedNumber = i + 1;

						next_image( i );

					}

				} ).fail( function( xhr, status, error ) {

					failedAttachments2++;

					if ( failedAttachments2 < 20 ) {

						import_attachments( importedNumber );

					} else if ( xhr.status == 500 ) {

						importerError( mtWizard.error_500 );

					} else if ( xhr.status == 503 ) {

						importerError( mtWizard.error_503 );

					} else {

						importerError( error || mtWizard.ajax_error );

					}

					console.error( xhr, status, error );

				} );
			}

			function next_image( i ) {

				i++;
				failedAttachments = 0;

				var listX = $( '.mt-list' );

				// Continue next image.
				if ( attachments[i] ) {

					import_attachments( i );

				// Import sldier.
				} else if ( listX.find( 'li[data-name="slider"]' ).length ) {

					var liLast = $( '.mt-list li' ).length;

					listX.find( 'li:nth-child(' + ( liLast - 1 ) + ')' ).removeClass( 'current' ).addClass( 'mt-done' ).prepend( '<span class="checkmark" aria-hidden="true"></span>' );

					importerAJAX( liLast, 'slider', 'import', false );

				} else {

					importerDone();

				}

			}

			if ( attachments[0] ) {

				import_attachments( 0 );

			} else {

				importerError( 'There were no attachment files found in the XML file.' );

			}

		}

	// Lazyload demos.
	$( window ).on( 'scroll.mt', function() {

		$( '.lazyload [data-src]' ).each( function() {

			var $this = $( this );

			if ( inViewport( $this, 100 ) ) {

				$this.attr( 'src', $this.attr( 'data-src' ) ).addClass( 'lazyDone' );

				if ( ! $( '.mt-demos img' ).not( '.lazyDone' ).length ) {

					$( window ).off( 'scroll.mt' );

				}

			}

		});

	}).trigger( 'scroll.mt' );

	// Search in demos.
	var searchDemos = function( value ) {

		var timeOut = 0;

		$( '.mt-demos > div' ).each( function() {

			var $this = $( this );

			if ( $this.text().search( new RegExp( value, 'i' ) ) < 0 ) {
				$this.hide();
			} else {
				$this.show();
			}

			clearTimeout( timeOut );

			timeOut = setTimeout( function() {
				$( window ).trigger( 'scroll.mt' );
			}, 250 );

		});

	};

	// Demo importer wizard start.
	$( 'body' ).on( 'click', '.mt-demos a[data-args]', function( e ) {

		args = JSON.parse( $( this ).attr( 'data-args' ) ),

		// Scroll to top.
		$( 'html, body' ).animate({ scrollTop: $( '.mt-dashboard-main' ).offset().top - 100 }, 1000 );

		// Show wizard.
		$( '.mt-demo-wrapper' ).slideUp( 'normal', function() {
			$( '.mt-wizard' ).slideDown( 'normal' );
		});

		// Reset progress.
		progress.css( 'width', '0%' ).find( 'span' ).html( '' );

		// Opacity wizard buttons.
		$( '.wizard-footer > a' ).css( 'opacity', '1' );

		// Reset to step 1.
		$( '[data-step="1"]' ).addClass( 'current' ).siblings().removeClass( 'current' );

		// Show footer.
		$( '.wizard-footer' ).show();

		// Set image.
		$( '.mt-demo-image' ).attr( 'src', args.image );

		// Set title.
		$( '.selected-demo strong' ).html( args.title ? args.title : args.demo.replace( /-/g, ' ' ) );

		// Set live preview.
		$( '.live-preview' ).attr( 'href', args.preview );

		if ( args.preview.indexOf( 'arabic' ) >= 0 ) {
			$( '.live-preview-elementor' ).attr( 'href', args.preview.replace( '/' + args.demo, '-elementor/' + args.demo ) );
		} else {
			$( '.live-preview-elementor' ).attr( 'href', args.preview.replace( args.demo, 'elementor/' + args.demo ) );
		}

		// Hide prev step button.
		$( '.wizard-footer .wizard-prev' ).attr( 'disabled', 'disabled' );

		// Check WPBakery.
		$( '[name="pagebuilder"][value="js_composer"]' )[ args.free && $( '.readonly' ).length ? 'attr' : 'removeAttr' ]( 'disabled', 'disabled' );

		// WPBakery.
		if ( args.js_composer != false ) {

			$( '.live-preview-wpbakery' ).show();
			$( '[name="pagebuilder"][value="js_composer"]' ).parent().show();

		} else {

			$( '.live-preview-wpbakery' ).hide();
			$( '[name="pagebuilder"][value="js_composer"]' ).parent().hide();

		}

		// Elementor.
		if ( args.elementor ) {

			// Check Elementor builder.
			$( '[name="pagebuilder"][value="elementor"]' ).trigger( 'click' );

		} else {

			$( '.live-preview-elementor' ).remove();

			$( '[name="pagebuilder"][value="elementor"]' ).attr( 'disabled', 'disabled' );

			$( '[name="pagebuilder"][value="js_composer"]' ).trigger( 'click' );

		}

		var lang = $( 'html' ).attr( 'lang' );

		// Check if demo have slider.
		$( '[name="slider"]' ).parent()[ ( args.plugins && args.plugins.revslider == false ) ? 'hide' : 'show' ]();

		e.preventDefault();

	// Tooltip.
	}).on( 'mouseenter', '[data-tooltip]', function( e ) {

		var $this = $( this );

		if ( ! $this.find( '.tooltip' ).length ) {

			$this.append( '<div class="tooltip">' + $this.attr( 'data-tooltip' ) + '</div>' );

		}

	
	// Import full or custom.
	}).on( 'click', '[name="config"]', function( e ) {

		$( '.mt-checkboxes' )[ $( this ).val() === 'custom' ? 'removeAttr' : 'attr' ]( 'disabled', 'disabled' );
	
	// Custom import activate.
	}).on( 'click', '.mt-checkboxes', function( e ) {

		$( '[name="config"][value="custom"]' ).trigger( 'click' );

	// Next and prev steps buttons.
	}).on( 'click', '.wizard-prev, .wizard-next', function( e ) {

		if ( $( 'body' ).hasClass( 'mt-importing' ) ) {
			return false;
		}

		var isNext 	= $( this ).hasClass( 'wizard-next' ),
			current = parseInt( $( '.wizard-steps .current' ).attr( 'data-step' ) ),
			step 	= ( isNext ? current + 1 : current - 1 ),
			isFull 	= $( '[name="config"]:checked' ).val() === 'full';

		if ( step >= 1 && step <= 5 ) {

			$( '.wizard-footer .wizard-prev' )[ step !== 1 ? 'removeAttr' : 'attr' ]( 'disabled', 'disabled' );

			// Validate check list.
			if ( isNext && step === 4 && ! isFull ) {

				var list = $( '.mt-checkboxes input:checkbox:checked' ).map( function() {
						return this.value;
					}).get();

				if ( ! list.length ) {

					alert( mtWizard.features );

					return false;

				}

			}

			// Set step.
			$( '.wizard-steps li[data-step="' + step + '"]' ).addClass( 'current' ).siblings().removeClass( 'current' );

			// Change content step.
			$( '.mt-wizard-content [data-step="' + step + '"]' ).addClass( 'current' ).siblings().removeClass( 'current' );

			// Start importing.
			if ( step === 4 ) {

				// Disable all links and only wait for import.
				$( 'body' ).addClass( 'mt-importing' );

				// Hide back to demos.
				$( '.mt-back-button' ).hide();

				// Opacity preview image.
				$( '.mt-demo-image' ).css( 'opacity', '.2' );

				// Opacity wizard buttons.
				$( '.wizard-footer > a' ).css( 'opacity', '.3' );

				// Show progress bar.
				$( '.wizard-progress, .importer-spinner' ).show();

				// Checks.
				var list = $( '.mt-list' ),
					pagebuilder = $( '[name="pagebuilder"]:checked' ).val(),
					isPluginInactive = function( slug ) {
						return mtWizard.plugins[ slug ];
					},
					pluginBefore = '<span class="list-before">' + mtWizard.plugin_before + '</span>',
					pluginAfter = '<span class="list-after">' + mtWizard.plugin_after + '</span>',
					importBefore = '<span class="list-before">' + mtWizard.import_before + '</span>',
					importAfter = '<span class="list-after">' + mtWizard.import_after + '</span>';

				list.empty();

				// Plugins.
				if ( isPluginInactive( 'modeltheme-addons-for-wpbakery' ) ) {
					list.append( '<li data-name="modeltheme-addons-for-wpbakery" data-type="plugin" data-pv="5" class="current">' + pluginBefore + mtWizard.modeltheme_addons_for_wpbakery + pluginAfter + '</li>' );
				}

				if ( pagebuilder === 'js_composer' && isPluginInactive( 'js_composer' ) ) {
					list.append( '<li data-name="js_composer" data-type="plugin" data-pv="7">' + pluginBefore + mtWizard.js_composer + pluginAfter + '</li>' );
				} else if ( pagebuilder === 'elementor' && isPluginInactive( 'elementor' ) ) {
					list.append( '<li data-name="elementor" data-type="plugin" data-pv="5">' + pluginBefore + mtWizard.elementor + pluginAfter + '</li>' );
				}

				if ( ( ! args.plugins || ( args.plugins && args.plugins.revslider != false ) ) && isPluginInactive( 'revslider' ) && ( isFull || $( '[name="slider"]' ).is( ':checked' ) ) ) {
					list.append( '<li data-name="revslider" data-type="plugin" data-pv="7">' + pluginBefore + mtWizard.revslider + pluginAfter + '</li>' );
				}

				if ( isPluginInactive( 'contact-form-7' ) ) {
					list.append( '<li data-name="contact-form-7" data-type="plugin" data-pv="3">' + pluginBefore + mtWizard.cf7 + pluginAfter + '</li>' );
				}

				if ( isPluginInactive( 'svg-support' ) ) {
					list.append( '<li data-name="svg-support" data-type="plugin" data-pv="3">' + pluginBefore + mtWizard.svg_support + pluginAfter + '</li>' );
				}

				if ( isPluginInactive( 'woocommerce' ) && ( isFull || $( '[name="woocommerce"]' ).is( ':checked' ) ) ) {
					list.append( '<li data-name="woocommerce" data-type="plugin" data-pv="4">' + pluginBefore + mtWizard.woocommerce + pluginAfter + '</li>' );
				}

				// Additional Plugins.
				args.plugins && $.each( args.plugins, function( plugin, value ) {

					value && isPluginInactive( plugin ) && list.append( '<li data-name="' + plugin + '" data-type="plugin" data-pv="5">' + pluginBefore + plugin + pluginAfter + '</li>' );

				});

				// Download demo file.
				list.append( '<li data-name="download" data-type="download" data-pv="8"><span class="list-before">' + mtWizard.downloading + '</span>' + mtWizard.demo_files + '<span class="list-after">' + mtWizard.downloaded + '</span></li>' );

				// Demo features.
				if ( isFull || $( '[name="options"]' ).is( ':checked' ) ) {
					list.append( '<li data-name="options" data-type="import" data-pv="2">' + importBefore + mtWizard.options + importAfter + '</li>' );
				}
				if ( isFull || $( '[name="widgets"]' ).is( ':checked' ) ) {
					list.append( '<li data-name="widgets" data-type="import" data-pv="1">' + importBefore + mtWizard.widgets + importAfter + '</li>' );
				}
				if ( isFull || $( '[name="content"]' ).is( ':checked' ) ) {
					list.append( '<li data-name="content" data-type="import" data-pv="15">' + importBefore + mtWizard.posts + importAfter + '<b></b></li>' );
				}
				if ( isFull || $( '[name="images"]' ).is( ':checked' ) ) {
					list.append( '<li data-name="images" data-type="import" data-pv="80">' + importBefore + mtWizard.images + importAfter + '<b></b></li>' );
				}
				if ( isFull || ( ! args.plugins || ( args.plugins && args.plugins.revslider != false ) ) && $( '[name="slider"]' ).is( ':checked' ) ) {
					list.append( '<li data-name="slider" data-type="import" data-pv="3">' + importBefore + mtWizard.slider + importAfter + '</li>' );
				}

				var failedAjax = 0,
					folder = '';

				
				// Change API to elementor.
				if ( pagebuilder === 'elementor' ) {

					folder = folder ? folder + '-' : '';
					folder = folder + 'elementor';

				}

				list.find( 'li' ).each( function() {
					allPv += parseInt( $( this ).attr( 'data-pv' ) );
				});

				// Wizard AJAX function.
				importerAJAX = function( step, name, type, posts ) {

					var li = list.find( 'li:nth-child(' + step + ')' );

					// Add loading spinner.
					if ( ! li.find( '.mt-loading' ).length ) {

						li.prepend( '<i class="mt-loading" aria-hidden="true"></i>' );

					}

					// Start.
					li.addClass( 'current' ).siblings().removeClass( 'current' );

					// Send.
					$.ajax(
						{
							type: 'POST',
							url: ajaxurl + '?force_delete_kit',
							data: {
								action: 'mt_wizard',
								demo: args.demo,
								step: step,
								name: name,
								type: type,
								posts: posts,
								nonce: nonce,
								folder: folder
							},
							success: function( obj ) {

								//console.log( obj );

								if ( ! obj ) {

									importerError( '1. ' + mtWizard.ajax_error );

									return false;

								}

								if ( typeof obj !== 'object' ) {

									// Fix redirects after plugin install.
									if ( obj.indexOf( '<body' ) >= 0 ) {

										importerAJAX( step, 'redirect' );

										return false;

									}

									// Sanitize response and extract object.
									obj = JSON.parse( '{' + obj.substring( obj.lastIndexOf( '{' ) + 1, obj.lastIndexOf( '}' ) ) + '}' );

								}

								// Failed step.
								if ( failedAjax == 3 ) {

									importerError( obj.message || mtWizard.ajax_error );

									return false;

								// Automatic try again upto 3 times.
								} else if ( ! obj || obj.status === '202' || obj.nonce ) {

									failedAjax++;

									importerAJAX( step, name, type );

									return false;
								}

								// Continue content.
								if ( obj.posts ) {

									importerAJAX( step, name, type, obj.posts );

									// Progress bar.
									var current = parseInt( progress.text() ) + ( Math.floor( Math.random() * 2 ) + 1 );

									progress.css( 'width', current + '%' ).attr( 'data-current', current ).find( 'span' ).html( current + '%' );

									return false;

								// Import images.
								} else if ( obj.xml ) {

									attachment_importer( obj.xml, li, parseInt( progress.text() ) + 4 );

									return false;

								}

								// Progress bar.
								progressBar( li, allPv );

								// Add checkmark.
								li.removeClass( 'current' ).addClass( 'mt-done' ).prepend( '<span class="checkmark" aria-hidden="true"></span>' );

								// Next item.
								if ( step < list.find( 'li' ).length ) {

									var next = li.next().addClass( 'current' );

									importerAJAX( ++step, next.attr( 'data-name' ), next.attr( 'data-type' ) );

								} else {

									importerDone();

								}

							},
							error: function( xhr, type, message ) {

								if ( xhr.status == 500 ) {

									importerError( mtWizard.error_500 );

								} else if ( xhr.status == 503 ) {

									importerError( mtWizard.error_503 );

								} else {
									
									importerError( message || mtWizard.ajax_error );

								}

								console.log( xhr, type, message );

							}
						}
					);

				};

				var li = list.find( 'li:nth-child(1)' );

				importerAJAX( 1, li.attr( 'data-name' ), li.attr( 'data-type' ) );

			}

		}

		e.preventDefault();

	// Back to demos.
	}).on( 'click', '.mt-back-button, .back-to-demos', function( e ) {

		if ( $( 'body' ).hasClass( 'mt-importing' ) ) {
			return false;
		}

		// Hide wizard.
		$( '.mt-wizard' ).slideUp( 'normal', function() {
			$( '.mt-demo-wrapper' ).slideDown( 'normal' );
		});

		e.preventDefault();

	// Plugins installation error close icon.
	}).on( 'click', '.error-close', function( e ) {

		$( this ).parent().remove();

		e.preventDefault();

	});

});;
