@include('layouts.admin.header')
	<!-- END NAVIGATION -->
	@include('layouts/admin/sidebar')

	<!-- MAIN PANEL -->
	<div class="right_col" role="main">
		<?php $nameRoute = Request::route()->getName();?>
		@yield('breadcrumbs_no_url')
		@yield('content')
	</div>
	<!-- PAGE FOOTER -->
@include('layouts/admin/footer')