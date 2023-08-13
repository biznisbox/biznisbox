<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ settings('company_name')}}</title>
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@vite('resources/scss/app.scss')
	<link id="theme-link" rel="stylesheet" href="/themes/lara-light-blue/theme.css">
	<script>
	window.App = {!! json_encode([
		'settings' => \settings()->getPublicSettings(),
	]); !!}
	</script>
</head>
<body>
	<noscript>
		<strong>We're sorry but this app doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
	</noscript>
	<div id="app"></div>
	@vite('resources/js/app.js')
</body>
</html>