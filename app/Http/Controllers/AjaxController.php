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
        *  Pull 1 Tweets and compact the array when passing into the view
        */
        $this->client->tweets_limit = 1;
        $tweets = $this->client->getFeed();

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
