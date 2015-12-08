<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request, Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Redirect, Input;

use GuzzleHttp\Client;

class SphinxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $keyword = Input::get('keyword');
        if ($keyword == '') $keyword = ' ';
        $rank_mode = Input::get('rankMode');
        $match_mode = Input::get('matchMode');

        // request sphinx service api to search by keyword
        $client = new Client(['base_uri' => 'http://192.168.33.10/api/']);
        $response = $client->request('GET', 'search', [
            'json' => 
                [
                    'keyword' => $keyword,
                    'rank_mode' => $rank_mode,
                    'match_mode' => $match_mode
                ]
        ]);

        $json = json_decode($response->getBody()->getContents());

        return Redirect::to('admin')->with('data', $json);
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
