<?php namespace App\Http\Controllers;

use App\Doc;

class HomeController extends Controller {

	public function index()
	{
		return view('AdminHome')->withFiles(array());
	}

}