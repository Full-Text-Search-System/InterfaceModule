<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request, Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\File;

use Redirect, Input;

class SimilarityAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $a = file('doc_similarity/SPH_score.txt');
        $list = array();

        $nameList = array();
        $idList = array();

        foreach($a as $line){
            $tmp = explode (':', $line);
            // store file name into list
            $file = File::find($tmp[0]);
            $name = $file->name;
            array_push($nameList, $name);
            array_push($idList, $tmp[0]);
            $list[$tmp[0]] = $tmp[1];
        }

        $res = array();

        $count = 0;
        foreach ($list as $key => $value) {
            $pairs = explode (',', $value);
            $scoreList = [];
            $index = 0;
            foreach ($pairs as $p) {
                if ($count == $index) {
                    array_push($scoreList, '0');
                }
                $tmp = explode('|', $p);
                array_push($scoreList, $tmp[1]);
                $index++;
            }
            array_push($res, $scoreList);
            $count++;
        }

        // add 0 to the last one
        array_push($res[count($res)-1], '0');
        
        $data['res'] = $res;
        $data['filenames'] = $nameList;
        $data['ids'] = $idList;

        return view('SimilarityAll', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Redirect::to('admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        
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
