<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterApi\GetUserTimelineFeed;

class WelcomeController extends Controller
{
    
    private $client;

    public function index(Request $request)
    {
        /*
        *  Get the post request, if empty the use my screen_name (mmb000) as default.
        */
        $handle = $request->input('twitter_handle');
        $handle = ($handle =='')? 'mmb000':$handle;
        
        /*
        *  Initiate the object
        */
        $this->client = new GetUserTimelineFeed($handle);
        
        /*
        *  Pull 5 Tweets and compact the array when passing into the view
        */
        $tweets = $this->client->getFeed();
       // print_r($tweets);
       // die();
        return view('welcome', compact('tweets','handle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
