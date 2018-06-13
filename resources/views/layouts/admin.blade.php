@include('layouts.admin.header')
	<!-- END NAVIGATION -->
	@include('layouts/admin/sidebar')

	<!-- MAIN PANEL -->
	<div id="main" role="main">
		<!-- RIBBON -->
		<div id="ribbon">
			<span class="ribbon-button-alignment">
				<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
					<i class="fa fa-refresh"></i>
				</span>
			</span>
			@if( !empty($breadcrumbs['1']) )
				{!! Breadcrumbs::render($breadcrumbs['0'], $breadcrumbs['1']) !!}
			@else
				{!! Breadcrumbs::render($breadcrumbs['0']) !!}
			@endif
		</div>
		<div id="content">
			<?php $nameRoute = Request::route()->getName();?>
			@yield('breadcrumbs_no_url')
			@yield('content')
		</div>
	</div>
	<!-- PAGE FOOTER -->
@include('layouts/admin/footer')