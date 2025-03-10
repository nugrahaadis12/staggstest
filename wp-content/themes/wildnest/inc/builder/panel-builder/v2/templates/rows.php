<script type="text/html" id="tmpl-wildnest--cb-panel-v2">
	<div class="cp-rows-v2 wildnest--cp-rows">

		<# if ( ! _.isUndefined( data.rows.top ) ) { #>
		<div class="wildnest--row-top wildnest--cb-row" data-row-id="top" data-id="{{ data.id }}_top">
			<a class="wildnest--cb-row-settings" title="{{ data.rows.top }}" data-id="top" href="#"></a>
			<div class="wildnest--row-inner">

				<div class="col-items-wrapper"><div data-id="left" class="col-items col-left"></div></div>
				<div class="col-items-wrapper"><div data-id="center" class="col-items col-center"></div></div>
				<div class="col-items-wrapper"><div data-id="right" class="col-items col-right"></div></div>

			</div>
		</div>
		<# } #>

		<# if ( ! _.isUndefined( data.rows.main ) ) { #>
		<div class="wildnest--row-main wildnest--cb-row" data-row-id="main" data-id="{{ data.id }}_main">
			<a class="wildnest--cb-row-settings" title="{{ data.rows.main }}" data-id="main" href="#"></a>

			<div class="wildnest--row-inner">
				
				<div class="col-items-wrapper"><div data-id="left" class="col-items col-left"></div></div>
				<div class="col-items-wrapper"><div data-id="center" class="col-items col-center"></div></div>
				<div class="col-items-wrapper"><div data-id="right" class="col-items col-right"></div></div>
				
			</div>
		</div>
		<# } #>

		<# if ( ! _.isUndefined( data.rows.bottom ) ) { #>
		<div class="wildnest--row-bottom wildnest--cb-row" data-row-id="bottom" data-id="{{ data.id }}_bottom">
			<a class="wildnest--cb-row-settings" title="{{ data.rows.bottom }}" data-id="bottom" href="#"></a>
			<div class="wildnest--row-inner">

				<div class="col-items-wrapper"><div data-id="left" class="col-items col-left"></div></div>
				<div class="col-items-wrapper"><div data-id="center" class="col-items col-center"></div></div>
				<div class="col-items-wrapper"><div data-id="right" class="col-items col-right"></div></div>

			</div>
		</div>
		<# } #>
	</div>


	<# if ( data.device != 'desktop' ) { #>
		<# if ( ! _.isUndefined( data.rows.sidebar ) ) { #>
		<div class="wildnest--cp-sidebar">
			<div class="wildnest--row-sidebar wildnest--cb-row" data-row-id="sidebar" data-id="{{ data.id }}_sidebar">
				<a class="wildnest--cb-row-settings" title="{{ data.rows.sidebar }}" data-id="sidebar" href="#"></a>
				<div class="wildnest--row-inner">

					<div class="col-items-wrapper"><div data-id="sidebar" class="col-items col-sidebar"></div></div>

				</div>
			</div>
			<div>
		<# } #>
	<# } #>

</script>