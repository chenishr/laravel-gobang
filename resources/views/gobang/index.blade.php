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
			<div v-for="(st,i) in stat" >
				<span v-for="(s,j) in st">@{{ stat[i][i] }} </span>
			</div>
			<div class="chessboard">
				<div class="chessboard-bg">
					<div v-for="cell in chessboard" class="cell" v-bind:class="['cell-row-' + cell[0],'cell-col-' + cell[1]]"> </div>
				</div>
				<div class="chess-bg">
					<!--div v-for="cell in chess" class="chess" v-bind:class="['chess-row-' + cell[0],'chess-col-' + cell[1],'chess-' + stat[cell[0]][cell[1]]]" v-on:click="one_step(cell[0],cell[1])"> </div-->
					<div v-for="(cell,i) in chess" class="chess" v-bind:class="['chess-row-' + chess[i][0],'chess-col-' + chess[i][1],'chess-' + chess[i][2]]" v-on:click="one_step(cell[0],cell[1])"> </div>
				</div>
			</div>		
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
