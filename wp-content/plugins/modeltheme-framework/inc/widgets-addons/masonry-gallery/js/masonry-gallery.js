jQuery( window ).on(
	"elementor/frontend/init",
	function () {
		var e = elementorModules.frontend.handlers.Base.extend(
			{
				bindEvents: function () {
					this.change();
				},
				change: function () {
					0 < jQuery( "body" ).find( ".elementor-widget-mtap-masonry-gallery > .elementor-widget-container" ).length &&
					jQuery( ".elementor-widget-mtap-masonry-gallery > .elementor-widget-container" ).each(
						function () {
							let t = jQuery( this ).find( ".mtap-masonry-gallery-wrapper" );
							t.find( ".mtap-masonry-gallery-item" ).hasClass( "mtap-masonry-gallery-item-with-lightbox" ) &&
							((e = "elementor-element-" + t.closest( ".elementor-widget-mtap-masonry-gallery" ).data( "id" )),
							t.magnificPopup(
								{
									delegate: ".mtap-masonry-gallery-item-with-lightbox",
									type: "image",
									closeOnContentClick: ! 1,
									closeBtnInside: ! 1,
									mainClass: "elementor-element mfp-with-zoom mfp-img-mobile mtap-masonry-gallery-lightbox " + e,
									prependTo: t.closest( ".elementor" ),
									zoom: {
										enabled: ! 0,
										duration: 300,
										easing: "ease-in-out",
										opener: function (e) {
											return e.is( "img" ) ? e : e.find( "img" );
										},
									},
									gallery: { enabled: ! 0, tPrev: "", tNext: "", tCounter: "" },
									image: {
										markup:
										'<div class="mfp-figure"><div class="mfp-close"></div><div class="mfp-img"></div><div class="mfp-bottom-bar ' +
										t.find( ".mtap-masonry-gallery-title-caption-wrapper" ).attr( "class" ) +
										'"><div class="mfp-title"></div></div></div>',
										titleSrc: function (e) {
											return 0 < e.el.find( ".mtap-masonry-gallery-title-caption-wrapper" ).length ? e.el.find( ".mtap-masonry-gallery-title-caption-wrapper" ).html() : "";
										},
										tError: '<a href="%url%">The image</a> could not be loaded.',
									},
								}
							));
							jQuery(window).on('load', function(){
								console.log("hello elicus.");
								t.imagesLoaded(
									function () {
										var e = t.isotope(
											{
												itemSelector: ".mtap-masonry-gallery-item",
												transformsEnabled : ! 1,
												layoutMode: "masonry",
												percentPosition: ! 0,
												resize: ! 0,
												masonry: { columnWidth: ".mtap-masonry-gallery-item", gutter: ".mtap-masonry-gallery-item_gutter" },
											}
										);
										e.isotope( 'layout' ); e.isotope( 'reloadItems' );
									}
								)
							});
						}
					);
				},
			}
		);
		elementorFrontend.elementsHandler.attachHandler( "mtap-masonry-gallery", e );
	}
);