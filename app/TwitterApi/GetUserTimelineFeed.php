<?php
/*
* - Class for retriving User Timeline Feed - Mauricio Masias
* -
* - input @String
* - return @Array
*/

namespace App\TwitterApi;


class GetUserTimelineFeed
{
   
    private $token_bearer_endpoint;
    private $access_token;
    private $user_timeline_endpoint;
    private $screen_name;
    public  $tweets_limit;
    private $tweets_filtered = [];
    
    public function __construct($handle)
    { 
        $this->token_bearer_endpoint =  'https://api.twitter.com/oauth2/token';
        $this->user_timeline_endpoint = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $this->screen_name = $handle;
        $this->tweets_limit = 5;
    }


    // @array
    public function getFeed()
    {

        /*
        *  In order to pull data from Twitter, you need first to obtain the Bearer Token
        *  this will be appended to the API request as header in cUrl calls
        */
        $this->access_token  = $this->getBearerToken();

        if ($this->access_token !== false){

            $all_tweets_data = $this->getUserTimeline();
            $tweets = [];
            

            foreach ($all_tweets_data as $tweet) {
               
                $text_filtered = $this->shapeDataToSendIntoView('text', $tweet->text);
                $hashtags = $this->shapeDataToSendIntoView('hashtags', $tweet->entities->hashtags);

                /*
                *  Satinize the variables depending of the twit content
                *  Check for retweet types because they don't have the same author and content
                */
                if(isset($tweet->entities->media)){

                    $media = $this->shapeDataToSendIntoView('images', $tweet->entities->media);
                    if(isset($tweet->retweeted_status)){
                        $author = $this->shapeDataToSendIntoView('author', $tweet->retweeted_status->user);
                    }else{
                        $author = $this->shapeDataToSendIntoView('author', $tweet->user);
                    }

                }elseif(isset($tweet->retweeted_status)){
                    $media['images'] = [];
                    $media['videos'] = [];
                    $author = $this->shapeDataToSendIntoView('author', $tweet->retweeted_status->user);
                }else{
                    $media['images'] = [];
                    $media['videos'] = [];
                    $author = $this->shapeDataToSendIntoView('author', $tweet->user);
                }

                $date = $this->shapeDataToSendIntoView('date', $tweet->created_at);

                

                $tweet_part_1 = [
                'id' => $tweet->id,
                'created' => $date,
                'text' => $text_filtered,
                'hashtags' => $hashtags,
                'images' => $media['images'],
                'image_count' => count($media['images']),
                'videos' => $media['videos'],
                'video_count' => count($media['videos']),
                ];

                /*
                *  Prepare the final array with the twit content and 
                *  the variable author content (usually on retweets)
                */
                $tweets[] = array_merge($tweet_part_1,$author);

            }
            
        }
        
        return  $tweets;
    }

    
    private function getBearerToken()
    {
        $shell_cmd  = "curl -u '".\Config::get('twitter.api_key').":".\Config::get('twitter.api_secret_key')."' ";
        $shell_cmd .= "--data 'grant_type=client_credentials' ";
        $shell_cmd .= "'".$this->token_bearer_endpoint."'";

        $token_response = json_decode(shell_exec($shell_cmd));

        return is_object($token_response)? $token_response->access_token:false;  
    }


    private function getUserTimeline()
    {
        $shell_cmd  = 'curl -X GET "';
        $shell_cmd .= $this->user_timeline_endpoint .'?screen_name='.$this->screen_name.'&count='.$this->tweets_limit;
        $shell_cmd .= '" -H "Authorization: Bearer ' . $this->access_token . '"';

        $token_response = json_decode(shell_exec($shell_cmd));

        return $token_response;
    }

    private function shapeDataToSendIntoView($type, $element)
    {
        /*
        *  Shape different types of data (json structure) into a unified format
        */
        switch($type){

            case 'images': 

                $images = [];
                $videos = [];

                foreach($element as $image){
                    
                    if($image->type == 'photo'){
                       $images[] = $image->media_url_https;
                    }elseif ($image->type == 'video') {
                       $videos[] = $image->media_url_https;
                    }
                }

                return [
                        'images' => $images, 
                        'videos' => $videos
                       ];
                break;

            case 'text':

                $text_filtered = explode('#',$element);
                return $text_filtered[0];
                break;  

            case 'hashtags':

                $hashtags=[];

                foreach($element as $hashtag){
                    $hashtags[] = '#'.$hashtag->text;
                }

                return $hashtags;
                break;

            case 'date':
                return date("jS F, Y", strtotime($element));
                break;

            case 'author':
                return [
                    'user'  => $element->name,
                    'screen_name' => $element->screen_name,
                    'followers_count' => $element->followers_count,
                    'friends_count' => $element->friends_count,
                    'statuses_count' => $element->statuses_count,
                    'user_image' => $element->profile_image_url_https
                ] ;             

        }
        

    }


}
