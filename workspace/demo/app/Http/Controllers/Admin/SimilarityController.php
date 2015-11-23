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
        // $files = $request->file('file');

        // if (!$request->hasFile('file')) {
        //     return Redirect::back()->withInput()->withErrors('Fail to upload file!');
        // }

        // // request sphinx service api to create new index for this file
        // $client = new Client();
        // // $batch_file = ['multipart' => []];

        // foreach ($files as $f) {
        //     // save each file's metadata to storage service
        //     if (!$f->isValid()) 
        //         continue;
        //     $file = new File;
        //     $file->location = 'file/'.$f->getClientOriginalName();
        //     $file->name     = $f->getClientOriginalName();  
        //     $file->save();

        //     $response = $client->request('POST', 'http://192.168.33.10/api/files', [
        //         'multipart' => [
        //             [
        //                 'name' => 'file',
        //                 'contents' => fopen($f->getRealPath(), 'r'),
        //                 'filename' => $file->name
        //             ],
        //             [
        //                 'name' => 'id',
        //                 'contents' => strval($file->id)
        //             ]
        //         ]
        //     ]);

        //     $json = json_decode($response->getBody()->getContents());
        //     // if ($json != null && $json->num == 0) {
        //     //     return Redirect::back()->withInput()->withErrors('success!');
        //     // }

        //     // save file local 
        //     $f->move('file', $file->name.'_'.$file->id);
        // }

        // return Redirect::to('admin');
        
        // return Redirect::back()->withInput()->withErrors('Fail to save!');
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
                
                // $tmpfile = File::find($split[0]);
                // $name = $tmpfile->name;
                // $res[$i] = array($name,$split[1]);
            }
            // $tmpfile = File::find($id);
            // $name = $tmpfile->name;
            // $res[count($res)] = array($name,0);   
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

        // $result ='';
        // foreach($res as $r ){
        //     $result = $result.','.$r;
        // }

        // $file->name = $result;

        //$data['first'] = array($res);
        $data['first'] = $res;
        //return view('Similarity')->with('result',$data);
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
