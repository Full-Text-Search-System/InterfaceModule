<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\File;

class AdminHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $val = [];

        $data = Session::get('data');
        Session::forget('data');
        if ($data == null) {
            $val['files'] = array();
            $val['matchMode'] = 'SPH_MATCH_BOOLEAN';
            $val['rankMode'] = 'SPH_RANK_PROXIMITY_BM25';
            $val['keyword'] = '';
            
            return view('AdminHome', $val);
        }

        $idList = $data->ids;

        $files = array();
        for ($i=0; $i<count($idList); $i++) {
            $files[$i] = File::find($idList[$i]);
        }

        $val['files'] = $files;
        $val['matchMode'] = $data->matchMode;
        $val['rankMode'] = $data->rankMode;
        $val['keyword'] = $data->keyword;

        return view('AdminHome', $val);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
    }
}
