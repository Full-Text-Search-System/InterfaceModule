<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request, Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Redirect, Input;

use App\Lib\SphinxClient;


class SphinxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // use sphinxapi to search by keyword
        $data = Input::json();
        $keyword = $data->get('keyword');
        $rank_mode = $data->get('rank_mode');
        $match_mode = $data->get('match_mode');


        $cl = new SphinxClient();
        $cl->setServer('127.0.0.1', 9312);

        /// match modes
        switch ($match_mode) {
            case "SPH_MATCH_BOOLEAN":
                $cl->setMatchMode(SPH_MATCH_BOOLEAN);
                break;
            case "SPH_MATCH_ANY":
                $cl->setMatchMode(SPH_MATCH_ANY);
                break;
            case "SPH_MATCH_ALL":
                $cl->setMatchMode(SPH_MATCH_ALL);
                break;
            // case "SPH_MATCH_FULLSCAN":
            //     $cl->setMatchMode(SPH_MATCH_FULLSCAN);
            //     break;
            default:
                $cl->setMatchMode(SPH_MATCH_BOOLEAN);
                break;
        }

        /// ranking modes (ext2 only)
        switch ($rank_mode) {
            case "SPH_RANK_PROXIMITY_BM25":
                $cl->setRankingMode(SPH_RANK_PROXIMITY_BM25);
                break;
            case "SPH_RANK_NONE":
                $cl->setRankingMode(SPH_RANK_NONE);
                break;
            case "SPH_RANK_WORDCOUNT":
                $cl->setRankingMode(SPH_RANK_WORDCOUNT);
                break;
            case "SPH_RANK_SPH04":
                $cl->setRankingMode(SPH_RANK_SPH04);
                break;
            default:
                $cl->setRankingMode(SPH_RANK_WORDCOUNT);
                break;
        }

        // can set weight for each attribute

        $result = $cl->Query($keyword, 'test1, testrt');
        $idList = array();

        if ($result['total_found'] != '0') {
            foreach ($result['matches'] as $key => $val) {
                $idList[] = $key;
            }
        }

        return Response::json(['data' => $idList]);
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
