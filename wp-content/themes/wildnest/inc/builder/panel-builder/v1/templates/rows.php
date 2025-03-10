<script type="text/html" id="tmpl-wildnest--cb-panel">
	<div class="wildnest--cp-rows">

		<# if ( ! _.isUndefined( data.rows.top ) ) { #>
		<div class="wildnest--row-top wildnest--cb-row" data-id="{{ data.id }}_top">
			<a class="wildnest--cb-row-settings" title="{{ data.rows.top }}" data-id="top" href="#"></a>
			<div class="wildnest--row-inner">
				<div class="row--grid">
					<?php
					for ( $i = 1; $i <= 12; $i ++ ) {
						echo '<div></div>';
					}
					?>
				</div>
				<div class="wildnest--cb-items grid-stack gridster" data-id="top"></div>
			</div>
		</div>
		<# } #>

		<# if ( ! _.isUndefined( data.rows.main ) ) { #>
		<div class="wildnest--row-main wildnest--cb-row" data-id="{{ data.id }}_main">
			<a class="wildnest--cb-row-settings" title="{{ data.rows.main }}" data-id="main" href="#"></a>

			<div class="wildnest--row-inner">
				<div class="row--grid">
					<?php
					for ( $i = 1; $i <= 12; $i ++ ) {
						echo '<div></div>';
					}
					?>
				</div>
				<div class="wildnest--cb-items grid-stack gridster" data-id="main"></div>
			</div>
		</div>
		<# } #>


		<# if ( ! _.isUndefined( data.rows.bottom ) ) { #>
		<div class="wildnest--row-bottom wildnest--cb-row" data-id="{{ data.id }}_bottom">
			<a class="wildnest--cb-row-settings" title="{{ data.rows.bottom }}" data-id="bottom" href="#"></a>
			<div class="wildnest--row-inner">
				<div class="row--grid">
					<?php
					for ( $i = 1; $i <= 12; $i ++ ) {
						echo '<div></div>';
					}
					?>
				</div>
				<div class="wildnest--cb-items grid-stack gridster" data-id="bottom"></div>
			</div>
		</div>
		<# } #>
	</div>


	<# if ( data.device != 'desktop' ) { #>
		<# if ( ! _.isUndefined( data.rows.sidebar ) ) { #>
		<div class="wildnest--cp-sidebar">
			<div class="wildnest--row-bottom wildnest--cb-row" data-id="{{ data.id }}_sidebar">
				<a class="wildnest--cb-row-settings" title="{{ data.rows.sidebar }}" data-id="sidebar" href="#"></a>
				<div class="wildnest--row-inner">
					<div class="wildnest--cb-items wildnest--sidebar-items" data-id="sidebar"></div>
				</div>
			</div>
			<div>
		<# } #>
	<# } #>

</script>
