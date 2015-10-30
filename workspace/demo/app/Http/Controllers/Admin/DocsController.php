<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Doc;
use App\Page;

use Redirect, Input, Auth;

class DocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('admin.docs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pub_date'    => 'required|date',
            'title'       => 'required|max:2000',
            'author'      => 'required|max:1000',
            'description' => 'required',
        ]);

        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return Redirect::back()->withInput()->withErrors('Fail to upload file!');
        }

        $doc = new Doc;
        $doc->pub_date    = Input::get('pub_date');
        $doc->title       = Input::get('title');
        $doc->author      = Input::get('author');
        $doc->description = Input::get('description');
        

        if ($doc->save()) {
            $request->file('file')->move('file', $request->file('file')->getClientOriginalName());
            return Redirect::to('admin');
        } else {
            return Redirect::back()->withInput()->withErrors('Fail to save!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
        return view('admin.pages.edit')->withPage(Page::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'title' => 'required|unique:pages|max:255',
            'body'  => 'required',
        ]);

        $page = Page::find($id);
        $page->title = Input::get('title');
        $page->body  = Input::get('body');
        $page->user_id = 1; //Auth::user()->id;

        if ($page->save()) {
            return Redirect::to('admin');
        } else {
            return Redirect::back()->withInput()->withErrors('Failed to save!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        $page = Page::find($id);
        $page->delete();

        return Redirect::to('admin');
    }
}
