<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request, Response;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\File;

use Redirect, Input;

use GuzzleHttp\Client;

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
        return view('admin.files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $files = $request->file('file');

        if (!$request->hasFile('file')) {
            return Redirect::back()->withInput()->withErrors('Fail to upload file!');
        }

        // request sphinx service api to create new index for this file
        $client = new Client();
        // $batch_file = ['multipart' => []];

        foreach ($files as $f) {
            // save each file's metadata to storage service
            if (!$f->isValid()) 
                continue;
            $file = new File;
            $file->location = 'file/'.$f->getClientOriginalName();
            $file->name     = $f->getClientOriginalName();  
            $file->save();

            $response = $client->request('POST', 'http://192.168.33.10/api/files', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($f->getRealPath(), 'r'),
                        'filename' => $file->name
                    ],
                    [
                        'name' => 'id',
                        'contents' => strval($file->id)
                    ]
                ]
            ]);

            $json = json_decode($response->getBody()->getContents());
            // if ($json != null && $json->num == 0) {
            //     return Redirect::back()->withInput()->withErrors('success!');
            // }

            // save file local 
            $f->move('file', $file->name.'_'.$file->id);
        }

        return Redirect::to('admin');
        
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
        $location = $file->location.'_'.$id;
        return Response::download($location, $file->name);
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
