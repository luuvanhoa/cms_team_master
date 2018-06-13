<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title> Thang máy Mạnh Tiến </title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="csrf_token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		{!! Html::style('css/bootstrap.min.css') !!}
		{!! Html::style('css/font-awesome.min.css') !!}
		{!! Html::style('css/smartadmin-production.min.css') !!}
		{!! Html::style('css/smartadmin-skins.min.css') !!}
		{!! Html::style('css/demo.min.css') !!}
		{!! Html::style('css/your_style.css') !!}
		<!-- FAVICONS -->
		<link rel="shortcut icon" href="{{asset('img/favicon/favicon.ico')}}" type="image/x-icon">
		<link rel="icon" href="{{asset('img/favicon/favicon.ico')}}" type="image/x-icon">

		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

	</head>
	<body>
		<header id="header">
			<div id="logo-group">
				<span id="logo">{!! Html::image('img/logo.png', 'SmartAdmin') !!}</span>
			</div>
			<div class="pull-right">

				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="{{route('login')}}" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
				</div>

				<div id="search-mobile" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
				</div>

				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
				</div>
			</div>
		</header>