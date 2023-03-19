<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ settings('company_name')}}</title>
	@vite('resources/scss/app.scss')
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