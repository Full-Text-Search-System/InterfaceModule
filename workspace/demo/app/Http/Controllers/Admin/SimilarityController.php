<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request, Response;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\File;

use Redirect, Input;

use GuzzleHttp\Client;

class SimilarityController extends Controller
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
        
           
        $file = File::find($id);
        $name = $file->name;


        $a = file('doc_similarity/SPH_score.txt');
        $tt;
        $list = array();
        $index = 0;

        foreach($a as $line){
            $tmp = explode (':', $line);
            $list[$tmp[0]] = $tmp[1];
        }

        $res = array();
        $tt = array();
        if(array_key_exists($id,$list)){
            $tmp = explode (',', $list[$id]);
            for ($i=0; $i<count($tmp); $i++) {
                $split = explode ('|', $tmp[$i]);
                if($split[1] != 0){
                    $tt[$split[0]] = $split[1];
                }
            }
        }
        arsort($tt);
        $count = 0;
        if(count($tt)>6){
            foreach($tt as $x=>$x_value){
                if($count > 6){
                    break;
                }
                $tmpfile = File::find($x);
                $name = $tmpfile->name;
                $res[$count++] = array($name,$x_value);
                
            }
        }else{
            foreach($tt as $x=>$x_value){
                 $tmpfile = File::find($x);
                 $name = $tmpfile->name;
                $res[$count++] = array($name,$x_value);
            }
        }
        $tmpfile = File::find($id);
        $name = $tmpfile->name;
        $res[count($res)] = array($name,0);   

        $data['first'] = $res;
        return view('Similarity', $data);
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
