<!doctype html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=751,user-scalable=no">
		<link rel="stylesheet" href="/css/app.css" />

        <title>五子棋小游戏</title>

		<script>
			 window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token(), ]); ?> 
		</script>

	</head>
	<body>
		<div id="app">
			
		</div>
		<script src="/js/app.js"></script>
		<script src="/js/jquery_transit.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var	clientHeight	= document.documentElement.clientHeight;
				if(1335 > clientHeight){
					console.log("document.body.clientHeight:" + clientHeight);                              
					var scale   = clientHeight / 1335;
					$("#app").css("transform","scale(" + scale +"," + scale + ")");                                       
				}
			});
		</script>
	</body>
</html>
