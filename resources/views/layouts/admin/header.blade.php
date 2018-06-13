<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title> CMS - Team master </title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="csrf_token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		{!! Html::style('css/bootstrap.min.css') !!}
		{!! Html::style('admin/css/font-awesome.min.css') !!}
		{!! Html::style('admin/css/nprogress.css') !!}
		{!! Html::style('admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') !!}
		{!! Html::style('admin/vendors/bootstrap-daterangepicker/daterangepicker.css') !!}
		{!! Html::style('admin/css/custom.min.css') !!}

		<!-- FAVICONS -->
		<link rel="shortcut icon" href="{{asset('admin/images/favicon.ico')}}" type="image/x-icon">
		<link rel="icon" href="{{asset('admin/images/favicon.ico')}}" type="image/x-icon">
	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">