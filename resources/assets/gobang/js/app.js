
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

// 棋盘的格子数目
var	chessboardWidth	= 9;
var	chessboardHeight= 9;

const app = new Vue({
    el: '#app',
	data:{
		chessboard:[],
		chess:[],
		stat:[],
		user: 1,
	},
	//mounted: function(){
	//	this.init();
	//},
	methods:{
		init:function(){
			this.pre_stat();
			this.pre_chess();
		},

		pre_stat: function(){
			var	tmp	= [];
			for(var i = 0; i <= chessboardWidth; i ++){
				//Vue.set(app.stat,i,[]);
				tmp[i]	= [];
				for(var j = 0; j <= chessboardHeight; j ++){
					// 格子状态
					//Vue.set(app.stat[i],j,0);
					tmp[i][j]	= 0;
				}
			}

			this.stat	= tmp;
		},

		pre_chess: function(){
			// 初始化棋盘数组
			var index	= 0;
			var cindex	= 0;
			var	chessboard	= [];
			var	stat	= '';
			for(var i = 0; i < chessboardWidth; i ++){
				for(var j = 0; j < chessboardHeight; j ++){

					// 背景格子
					var cls1	= i;
					var cls2	= j;
					Vue.set(app.chessboard,index,[cls1,cls2]);

					// 棋子
					var	che1	= i;
					var	che2	= j;
					stat	= this.get_stat(che1,che2);
					Vue.set(app.chess,cindex,[che1,che2,stat]);
					
					cindex ++;
					index ++;

					// 每行最后一个棋子
					if(j == chessboardHeight - 1){
						che1	= i;
						che2	= (j + 1);
						stat	= this.get_stat(che1,che2);
						Vue.set(app.chess,cindex,[che1,che2,stat]);
						cindex ++;
					}
				}

				// 最后一行棋子
				if(i == chessboardWidth - 1){
					for(var j = 0; j <= chessboardWidth; j ++){
						che1	= (i + 1);
						che2	= j;
						stat	= this.get_stat(che1,che2);
						Vue.set(app.chess,cindex,[che1,che2,stat]);
						cindex ++;
					}
				}
			}
		},

		get_stat: function(che1,che2){
			var	stat	= 0;

			try {
				stat	= typeof(this.stat[che1][che2]) != 'undefined' ? this.stat[che1][che2] : 0;
			} catch(e) {}

			return stat;
		},

		gen_class: function(cell){
			console.dir(cell);
			return cell;
		},

		one_step: function(row,col){
			if(0 != this.stat[row][col]){
				alert('非法落子');
				return false;
			}

			Vue.set(this.stat[row],col, this.user);
			console.dir(this.stat);

			// 测试 ，切换用户
			if(1 == this.user)
				this.user	= 2;
			else
				this.user	= 1;
		}
	}

});

app.init();
console.dir(app.chessboard);
console.dir(Vue);
console.dir(app);
