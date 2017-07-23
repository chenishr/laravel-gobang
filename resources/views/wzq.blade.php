<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="/css/app.css" />

        <title>Laravel</title>

		<script> window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token(), ]); ?> </script>

	</head>
	<body class="test">
		<div id="app">
		<h3> 你好，@{{ name }} @{{ gender }}  @{{ age }} @{{ addr }}！</h3>
		</div>
		<script src="/js/app.js"></script>
		<script type="text/javascript">
		</script>
	</body>
</html>
