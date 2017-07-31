<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GobangController extends Controller {
	const	WAITTING	= 'GOBANG_WAITING';
    //
	public function index(){
		//$users	= DB::select('select * from user');
		//var_dump($users);

		$this->create_chess(1);

		return view('gobang.index');
	}

	protected function create_chess(int $userId){
		$id	= 0;

		try{
			// 添加一条棋盘信息
			$id = DB::table('gobang')->insertGetId( ['user_a' => $userId]);

			// 添加入待匹配队列
			Redis::lpush(self::WAITTING,$id);

		}catch(Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}


		return $id;
	}

}
