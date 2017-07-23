<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GobangController extends Controller
{
    //
	public function index(){
		$users	= DB::select('select * from user');
		//var_dump($users);

		return view('gobang.index');
	}
}
