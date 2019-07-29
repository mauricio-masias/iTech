@extends('layouts.homepage')

@section('content')
<div class="topper content">
    <p>Add a Twitter Screen name to populate the widget. <br>It uses "mmb000" as default. Refreshes every 30 secs.</p>
    <div class="selector">
        <form id="handle" method="post" enctype="multipart/form-data" action="">
            @csrf
            <input type="text" name="twitter_handle" placeholder="mmb000" class="twitter_handle" value="{{ $handle }}">
            <input type="submit" value="Update widget" class="load">
        </form>
    </div>
    <p id="show_messages"></p>
</div>

<div class="flex-center position-ref">
    <div class="content">

    <div class="tweets_container">
        @forelse($tweets as $tweet)
                        
            <div class="item" rel="{{ $tweet['id'] }}">
                        
                <div class="main_tweet_container">
                    <div>            
                    <p class="main_tweet">{{ $tweet['text'] }}
                    @foreach($tweet['hashtags'] as $hash) {{ $hash }} @endforeach
                    </p>
                        
                    <p>{{ $tweet['created'] }} - Images:  {{ $tweet['image_count'] }} - Videos: {{ $tweet['video_count'] }}</p>
                    </div>
                    <div class="trigger">
                        <i class="arrow down"></i>
                    </div>
                </div>
                            
                <div class="hidden">
                    <div class="images_container">
                        @if($tweet['image_count'] > 0)
                            @foreach($tweet['images'] as $image)
                                <img src="{{$image}}" alt="Twitter image" class="tweet_images">
                            @endforeach
                        @endif

                        @if($tweet['video_count'] > 0)
                            @foreach($tweet['videos'] as $video)
                                <video width="320" height="240" controls>
                                    <source src="{{$video}}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endforeach
                        @endif
                    </div>

                    <div class="stats">
                        <div class="user_image">
                            <img src="{{ $tweet['user_image'] }}" alt="{{ $tweet['user'] }}">
                        </div>
                        
                        <div class="user_stats">
                            <p>Author: {{ $tweet['user'] }} [{{ $tweet['screen_name'] }}]</p>
                            <p>Followers: {{ $tweet['followers_count'] }}</p>
                            <p>Friends: {{ $tweet['friends_count'] }}</p>
                            <p>Statuses: {{ $tweet['statuses_count'] }}</p>
                        </div>
                                       
                    </div>
                </div>   
            </div>    
                        
        @empty
            <p>No tweets available</p>
        @endforelse
    </div>
</div>
</div>    
@endsection