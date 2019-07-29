<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterApi\GetUserTimelineFeed;

class AjaxController extends Controller
{
    
    private $client;

    public function index(Request $request)
    {
        $id = json_decode(urldecode($request->input('id')));
        $handle = json_decode(urldecode($request->input('handle')));
        $error='';
        
        /*
        *  Initiate the object
        */
        $this->client = new GetUserTimelineFeed($handle);
        
        /*
        *  Pull 1 Tweet and compact the array when passing into the view
        */
        $this->client->tweets_limit = 1;
        $tweets = $this->client->getFeed();

        /*
        * Compare the last tweet ID with the API last Tweet.
        * If ID same then let user know
        * IF ID different, refresh the widget to load the new tweet
        */
        if($tweets[0]['id'] == $id){
            //no change
            $status = 'no-change';
            return response()->json(array('status'=> $status,'error'=>$error), 200);
        }else{
            //need to update
            $status = 'need-update';
            return response()->json(array('status'=> $status,'error'=>$error), 200);
        }
       
        
    }

   
}
