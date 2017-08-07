<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GobangController extends Controller {
	const	WAITTING	= 'GOBANG_WAITING';
    //
	public function index(Request $request){
		if(!$this->check_user($request)){
			echo 'login please!';
			exit;
		}

		$this->create_chess(1);

		return view('gobang.index');
	}

	// 检查用户是否存在会话
	protected function check_user($request){
		if($request->has('user')){
			session('userId',$request->has('user'));
			session('gobangId',$request->has('gobang'));
		}

		$userId		= session('userId');
		$gobangId	= session('gobangId');

		$chess	= $this->get_gobang_chess($gobangId);
	}

	protected function set_gobang_user($gobangId,$userId,$client){
		$gobang	= Redis::hset('GOBANG:'.$gobangId,'USER:'.$userId,$client);
	}


	protected function set_gobang_chess($gobangId,$chess){
		$gobang	= Redis::hset('GOBANG:'.$gobangId,'CHESS',$chess);
	}


	protected function get_gobang_user($gobangId,$userId){
		$gobang	= Redis::hget('GOBANG:'.$gobangId,'USER:'.$userId);
	}


	protected function get_gobang_chess($gobangId){
		$gobang	= Redis::hget('GOBANG:'.$gobangId,'CHESS');
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
