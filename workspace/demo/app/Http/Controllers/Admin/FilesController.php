<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request, Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\File;
use App\Rtindex;

use Redirect, Input;

use Foolz\SphinxQL\SphinxQL;
use Foolz\SphinxQL\Connection;
use Foolz\SphinxQL\Helper;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return Response::json(['data' => 'no file']);
        }

        $id = Input::get('id');
        $filename = $request->file('file')->getClientOriginalName();  
        $content = file_get_contents($request->file('file')->getRealPath());  
        $request->file('file')->move('file', $filename.'_'.$id);

        // update rt index
        // check size
        $rtids = Rtindex::all();
        $start_id = $rtids[0]->start_id;
        $end_id = $rtids[0]->end_id;
        $size = $end_id - $start_id;

        $conn = new Connection();
        $conn->setParams(array('host' => '127.0.0.1', 'port' => 9306));

        if ($size >= 1) {
            // clear all index in rt-index
            $code;
            Helper::create($conn)->truncateRtIndex('testrt')->execute();

            // build delta-index and merge it into main-index
            system('sudo indexer --merge test1 testdelta --rotate', $code);
            system('sudo indexer testdelta --rotate', $code);
            
            $rtids[0]->start_id = intval($id);
        }

        $query = SphinxQL::create($conn)->insert()->into('testrt');
        $query->columns('id', 'filename', 'content')->values($id, $filename, $content);

        $result = $query->execute();

        $rtids[0]->end_id = intval($id);

        $rtids[0]->save();

        return Response::json(['data' => 'ok']);
        // if ($request != null) {
        //     return Response::json(['data' => 'ok']);
        // } else {
        //     return Response::json(['data' => 'not ok']);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        
    }
}
