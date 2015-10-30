<?php namespace App\Http\Controllers;

use App\Doc;

class DocsController extends Controller {

  public function show($id)
  {
    return view('docs.show')->withDoc(Doc::find($id));
  }

}