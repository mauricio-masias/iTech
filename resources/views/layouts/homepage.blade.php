<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Twitter API : Feed : Mauricio Masias</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>html,body{background-color:#fff;color:#636b6f;font-family:'Nunito',sans-serif;font-weight:200;margin:0}.flex-center{align-items:center;display:flex;justify-content:center}.position-ref{position:relative}.top-right{position:absolute;right:10px;top:18px}.content{text-align:center}.tweets_container{width:400px;padding:10px;border:5px solid #009dff;border-radius:10px}.images_container img{width:300px;box-shadow:0 0 5px #000}.stats{width:100%;overflow:hidden;background:#009dff;color:#fff;padding:10px 0 3px}.stats .user_image{width:20%;float:left}.stats .user_stats{width:80%;float:left}.stats .user_stats p{margin:0 0 3px;line-height:15px;text-align:left;font-size:15px}.item{border:1px solid #009dff;margin-bottom:10px;padding:5px 0 0}.item p{margin:0 0 5px;font-size:14px}.item p.main_tweet{font-size:18px}i{border:solid #009dff;border-width:0 3px 3px 0;display:inline-block;padding:8px}.up{transform:rotate(-135deg);-webkit-transform:rotate(-135deg);margin-top:8px}.down{transform:rotate(45deg);-webkit-transform:rotate(45deg)}.main_tweet_container{display:flex;flex-direction:row;flex-wrap:wrap}.main_tweet_container div{width:90%}.main_tweet_container div.trigger{width:10%}.hidden{display:none;margin:10px 0}.twitter_handle{font-size:60px;height:80px;width:400px;border-radius:10px}.load{background:#009dff;padding:0 10px;height:50px;font-size:20px;color:#fff;border-radius:10px;cursor:pointer}.selector{padding:10px 0;margin:10px 0 30px}.topper{background:#ddd;padding:10px 0 0}footer{background:#ddd;height:30px;text-align:center;padding:10px 0;margin:50px 0 0;line-height:30px}footer p{margin:0}#show_messages{display:none;color:#fff;font-size:20px;font-weight:600;margin: 0px 0 20px 0;background:#666}</style>
  </head>
  <body>
    
    @yield('content')

    <footer>
        <p>Twitter API test for iTech Media: Mauricio Masias - <a href="https://www.linkedin.com/in/mauriciomasias/" target="_blank">LinkedIn</a> </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
      $(document).ready(function () {
        $('.trigger').on('click',function(){
           if($(this).find('i').hasClass('down')){
            $(this).find('i').addClass('up').removeClass('down');
            $(this).parent().parent().find('.hidden').slideDown(200);
           }else{
            $(this).find('i').removeClass('up').addClass('down');
            $(this).parent().parent().find('.hidden').slideUp(200);
           }
        });

        setInterval(function(){ 
            var id = $(".tweets_container:first-child").attr("rel");
            var handle = $('.twitter_handle').val();
            checkForNewTweets(id,handle); 
        }, 30000);

        function checkForNewTweets(tweet_id,tweet_handle){

            $("#show_messages").hide().html('Checking for new Tweets...').fadeIn(200);
            var id_ready = encodeURIComponent(JSON.stringify(tweet_id));
            var handle_ready = encodeURIComponent(JSON.stringify(tweet_handle));
            $.ajax({
              type:'POST',
              url:'{{ url('/check-new-tweets') }}',
              data:{_token : "<?php echo csrf_token(); ?>",id:id_ready,handle:handle_ready},
              success:function(data){
                if(data.status!='no-change'){
                  $("#show_messages").hide().html('No new tweets found').fadeIn(200);
                }else{
                  $("#show_messages").hide().html('New Tweet found, refreshing ...').fadeIn(200,function(){location.reload();});
                }
              }
            });
        }   
      });
    </script>
  </body>
</html>

